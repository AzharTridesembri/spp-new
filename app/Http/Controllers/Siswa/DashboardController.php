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
        // Ambil data siswa pertama sebagai contoh (dummy)
        $siswa = Siswa::first();

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

        return view('siswa.dashboard', compact(
            'siswa',
            'totalBayar',
            'totalTunggakan',
            'recentPayments',
            'statusPembayaran'
        ));
    }
}
