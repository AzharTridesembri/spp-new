@extends('layouts.petugas')

@section('title', 'Dashboard Petugas')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
    <!-- Total Siswa Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
        <div class="rounded-full bg-blue-100 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
            </svg>
        </div>
        <div class="ml-4">
            <h2 class="text-gray-600 text-sm font-medium uppercase">Total Siswa</h2>
            <p class="text-gray-900 text-2xl font-semibold">{{ $totalSiswa }}</p>
        </div>
    </div>
    <!-- Total Petugas Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
        <div class="rounded-full bg-yellow-100 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
        </div>
        <div class="ml-4">
            <h2 class="text-gray-600 text-sm font-medium uppercase">Total Petugas</h2>
            <p class="text-gray-900 text-2xl font-semibold">{{ $totalPetugas }}</p>
        </div>
    </div>
    <!-- Total Pembayaran Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
        <div class="rounded-full bg-purple-100 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-4">
            <h2 class="text-gray-600 text-sm font-medium uppercase">Total Pembayaran</h2>
            <p class="text-gray-900 text-2xl font-semibold">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<div class="bg-white rounded-lg shadow p-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Pembayaran Terbaru</h2>
    <div class="space-y-4">
        @forelse($recentPayments as $payment)
        <div class="flex items-start">
            <div class="rounded-full bg-gray-100 p-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="ml-3 flex-1">
                <div class="flex justify-between items-center">
                    <p class="text-sm font-medium text-gray-900">{{ $payment->siswa->nama ?? '-' }}</p>
                    <p class="text-xs text-gray-500">{{ $payment->created_at->diffForHumans() }}</p>
                </div>
                <p class="text-sm text-gray-600">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }} - {{ $payment->bulan_dibayar }} {{ $payment->tahun_dibayar }}</p>
                <p class="text-xs text-gray-500">Oleh: {{ $payment->user->name ?? '-' }}</p>
            </div>
        </div>
        @empty
        <p class="text-sm text-gray-500">Belum ada pembayaran</p>
        @endforelse
    </div>
</div>
@endsection 