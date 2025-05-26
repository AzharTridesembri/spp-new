<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Pembayaran;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'spp'])->orderBy('nama');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nama', 'like', '%' . $searchTerm . '%')
                ->orWhere('nisn', 'like', '%' . $searchTerm . '%')
                ->orWhere('nis', 'like', '%' . $searchTerm . '%');
        }

        $siswas = $query->paginate(10);

        return view('petugas.siswa.index', compact('siswas'));
    }

    /**
     * Display payment history for a specific student.
     */
    public function paymentHistory(Siswa $siswa)
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

        // Jika siswa belum punya pembayaran, tampilkan semua bulan sebagai belum dibayar untuk tahun sekarang
        if ($payments->isEmpty()) {
            $currentYear = date('Y');
            $history[$currentYear] = [
                'paid' => [],
                'unpaid' => $allMonths
            ];
        }

        // Sort history by year
        krsort($history);

        return view('petugas.siswa.payment_history', compact('siswa', 'history'));
    }
}
