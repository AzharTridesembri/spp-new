<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display admin dashboard
     */
    public function index()
    {
        // Count data for dashboard stats
        $totalSiswa = Siswa::count();
        $totalKelas = Kelas::count();
        $totalPetugas = User::where('role', 'petugas')->count();
        $totalPembayaran = Pembayaran::sum('jumlah_bayar');

        // Get recent payments
        $recentPayments = Pembayaran::with(['siswa', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get monthly payment stats for chart
        $monthlyPayments = Pembayaran::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(jumlah_bayar) as total')
        )
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalKelas',
            'totalPetugas',
            'totalPembayaran',
            'recentPayments',
            'monthlyPayments'
        ));
    }
}
