<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Spp;
use App\Models\Siswa;

class DashboardController extends Controller
{
    /**
     * Display dashboard for siswa tanpa login
     */
    public function index()
    {
        // Ambil data siswa berdasarkan user yang login
        $siswa = Siswa::where('user_id', auth()->id())->first();

        if (!$siswa) {
            return view('siswa.dashboard', [
                'siswa' => null,
                'totalBayar' => 0,
                'totalTunggakan' => 0,
                'recentPayments' => collect(),
                'statusPembayaran' => []
            ]);
        }

        // Get total payments made by this siswa
        $totalBayar = Pembayaran::where('siswa_id', $siswa->id)->sum('jumlah_bayar');

        // Get SPP data for this siswa
        $spp = Spp::find($siswa->spp_id);
        $biayaPerBulan = $spp ? $spp->nominal : 0;

        // Calculate total tunggakan (12 months * SPP amount - paid amount)
        $totalSeharusnya = 12 * $biayaPerBulan;
        $totalTunggakan = $totalSeharusnya - $totalBayar;
        if ($totalTunggakan < 0)
            $totalTunggakan = 0;

        // Get recent payments
        $recentPayments = Pembayaran::where('siswa_id', $siswa->id)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Prepare payment status by month
        $bulan = [
            'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        ];

        $statusPembayaran = [];
        foreach ($bulan as $index => $namaBulan) {
            $bulanDibayar = $index + 1;
            $sudahBayar = Pembayaran::where('siswa_id', $siswa->id)
                ->where('bulan_dibayar', $namaBulan)
                ->where('tahun_dibayar', date('Y'))
                ->exists();

            $statusPembayaran[] = [
                'bulan' => $namaBulan,
                'status' => $sudahBayar ? 'LUNAS' : 'BELUM BAYAR'
            ];
        }

        $historyByYear = $this->paymentHistoryByYear($siswa);

        return view('siswa.dashboard', compact(
            'siswa',
            'totalBayar',
            'totalTunggakan',
            'recentPayments',
            'statusPembayaran',
            'historyByYear'
        ));
    }

    /**
     * Display payment history by year for a specific student.
     */
    public function paymentHistoryByYear(Siswa $siswa)
    {
        // Ambil semua pembayaran untuk siswa ini
        $payments = $siswa->pembayaran()->orderBy('tahun_dibayar', 'asc')->orderBy('bulan_dibayar', 'asc')->get();

        // Daftar semua bulan dalam setahun
        $allMonths = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Kelompokkan pembayaran per tahun
        $paymentsByYear = $payments->groupBy('tahun_dibayar');

        // Siapkan data riwayat pembayaran per tahun
        $history = [];
        foreach ($paymentsByYear as $year => $paymentsInYear) {
            $paidMonths = $paymentsInYear->pluck('bulan_dibayar')->toArray();
            $unpaidMonths = array_diff($allMonths, $paidMonths);

            // Urutkan bulan yang belum dibayar sesuai urutan kalender
            usort($unpaidMonths, function ($a, $b) use ($allMonths) {
                return array_search($a, $allMonths) - array_search($b, $allMonths);
            });

            // Urutkan bulan yang sudah dibayar sesuai urutan kalender
            usort($paidMonths, function ($a, $b) use ($allMonths) {
                return array_search($a, $allMonths) - array_search($b, $allMonths);
            });


            $history[$year] = [
                'paid' => $paidMonths,
                'unpaid' => $unpaidMonths,
            ];
        }

        // Jika siswa belum punya pembayaran, dan ada tahun sekarang, tambahkan tahun sekarang dengan semua bulan belum dibayar
        $currentYear = date('Y');
        if (!isset($history[$currentYear])) {
            $history[$currentYear] = [
                'paid' => [],
                'unpaid' => $allMonths
            ];
        } else {
            // Jika ada pembayaran di tahun sekarang, pastikan semua bulan termasuk (yang belum dibayar)
            $existingMonths = array_merge($history[$currentYear]['paid'], $history[$currentYear]['unpaid']);
            $missingMonths = array_diff($allMonths, $existingMonths);
            $history[$currentYear]['unpaid'] = array_merge($history[$currentYear]['unpaid'], $missingMonths);
            usort($history[$currentYear]['unpaid'], function ($a, $b) use ($allMonths) {
                return array_search($a, $allMonths) - array_search($b, $allMonths);
            });
        }

        // Sort history by year (descending)
        krsort($history);

        return $history;
    }
}
