<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        // Contoh data untuk laporan
        $data = [
            'title' => 'Laporan Contoh',
            'subtitle' => 'Ini adalah contoh laporan',
            'date' => now()->format('d F Y'),
            'footer' => 'Dicetak oleh: ' . auth()->user()->name ?? 'User',
            // Tambahkan data lain yang diperlukan
        ];

        return view('reports.print', $data);
    }

    // Method untuk laporan spesifik
    public function customReport(Request $request)
    {
        // Validasi request jika diperlukan
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            // Tambahkan validasi lain sesuai kebutuhan
        ]);

        // Ambil data sesuai parameter
        $data = [
            'title' => $request->title ?? 'Laporan Kustom',
            'subtitle' => $request->subtitle ?? '',
            'date' => now()->format('d F Y'),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'footer' => 'Dicetak oleh: ' . auth()->user()->name ?? 'User',
            // Tambahkan data lain sesuai kebutuhan
        ];

        return view('reports.print', $data);
    }
}