<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display dashboard for petugas tanpa login
     */
    public function index()
    {
        // Data ringkasan
        $totalSiswa = Siswa::count();
        $totalPembayaran = Pembayaran::sum('jumlah_bayar');
        $totalPetugas = User::where('role', 'petugas')->count();

        // Pembayaran terbaru
        $recentPayments = Pembayaran::with(['siswa', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('petugas.dashboard', compact(
            'totalSiswa',
            'totalPembayaran',
            'totalPetugas',
            'recentPayments'
        ));
    }
}
