@extends('layouts.siswa')

@section('title', 'Dashboard Siswa')

@section('content')
@if (!$siswa)
<div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
    <p>Data siswa tidak ditemukan. Silakan hubungi administrator.</p>
</div>
@else
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
    <!-- Profile Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Profil Siswa</h2>
        <div class="space-y-3">
            <div>
                <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                <p class="text-gray-900">{{ $siswa->nama }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">NIS</p>
                <p class="text-gray-900">{{ $siswa->nis }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">NISN</p>
                <p class="text-gray-900">{{ $siswa->nisn }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Kelas</p>
                <p class="text-gray-900">{{ $siswa->kelas->nama_kelas }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Alamat</p>
                <p class="text-gray-900">{{ $siswa->alamat }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">No. Telepon</p>
                <p class="text-gray-900">{{ $siswa->no_telp }}</p>
            </div>
        </div>
    </div>

    <!-- Payment Summary Card -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Ringkasan Pembayaran</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-3 bg-blue-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-blue-800">Total Dibayar</p>
                    <p class="text-blue-900 font-semibold text-lg">Rp {{ number_format($totalBayar, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-full bg-blue-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                <div>
                    <p class="text-sm font-medium text-red-800">Total Tunggakan</p>
                    <p class="text-red-900 font-semibold text-lg">Rp {{ number_format($totalTunggakan, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-full bg-red-100 p-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions Card -->
    <div class="bg-white rounded-lg shadow p-6 lg:col-span-1">
        <h2 class="text-lg font-semibold text-gray-700 mb-4">Transaksi Terakhir</h2>
        <div class="space-y-4">
            @forelse($recentPayments as $payment)
            <div class="flex items-start">
                <div class="rounded-full bg-green-100 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3 flex-1">
                    <div class="flex justify-between items-center">
                        <p class="text-sm font-medium text-gray-900">{{ $payment->bulan_dibayar }} {{ $payment->tahun_dibayar }}</p>
                        <p class="text-xs text-gray-500">{{ $payment->created_at->format('d/m/Y') }}</p>
                    </div>
                    <p class="text-sm text-gray-600">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }}</p>
                    <p class="text-xs text-gray-500">Oleh: {{ $payment->user->name }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500">Belum ada pembayaran</p>
            @endforelse
            
            <div class="mt-4">
                <a href="{{ route('siswa.history.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua Riwayat</a>
            </div>
        </div>
    </div>
</div>

<!-- Payment Status Card -->
<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Status Pembayaran {{ date('Y') }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($statusPembayaran as $status)
        <div class="border rounded-lg p-4 flex justify-between items-center">
            <p class="font-medium text-gray-700">{{ $status['bulan'] }}</p>
            @if($status['status'] === 'LUNAS')
            <span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">LUNAS</span>
            @else
            <span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">BELUM BAYAR</span>
            @endif
        </div>
        @endforeach
    </div>
</div>

{{-- Payment History By Year Card --}}
<div class="bg-white rounded-lg shadow p-6 mt-6">
    <h2 class="text-lg font-semibold text-gray-700 mb-4">Riwayat Pembayaran SPP per Tahun</h2>

    @forelse ($historyByYear as $year => $data)
        <div class="mb-6 p-4 border rounded-md bg-gray-50">
            <h3 class="font-semibold text-lg mb-3 text-gray-800">Tahun: {{ $year }}</h3>

            {{-- Bulan Sudah Dibayar --}}
            <div class="mb-4">
                <p class="font-semibold mb-2 text-green-700">Bulan Sudah Dibayar ({{ count($data['paid']) }}):</p>
                @if(count($data['paid']) > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($data['paid'] as $month)
                            <span class="bg-green-200 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $month }}</span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-sm">Belum ada pembayaran untuk tahun ini.</p>
                @endif
            </div>

            {{-- Bulan Belum Dibayar --}}
            <div>
                 <p class="font-semibold mb-2 text-red-700">Bulan Belum Dibayar ({{ count($data['unpaid']) }}):</p>
                 @if(count($data['unpaid']) > 0)
                     <div class="flex flex-wrap gap-2">
                         @foreach($data['unpaid'] as $month)
                             <span class="bg-red-200 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $month }}</span>
                         @endforeach
                     </div>
                 @else
                     <p class="text-gray-600 text-sm">Semua bulan sudah dibayar untuk tahun ini.</p>
                 @endif
            </div>
        </div>
    @empty
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-md">
            Belum ada riwayat pembayaran per tahun untuk siswa ini.
        </div>
    @endforelse

</div>
@endif
@endsection