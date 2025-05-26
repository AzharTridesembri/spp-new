@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">Riwayat Pembayaran Siswa: {{ $siswa->nama }}</h1>

    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold mb-4">Informasi Siswa</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p><span class="font-semibold">NISN:</span> {{ $siswa->nisn }}</p>
                <p><span class="font-semibold">NIS:</span> {{ $siswa->nis }}</p>
                <p><span class="font-semibold">Nama:</span> {{ $siswa->nama }}</p>
                <p><span class="font-semibold">Kelas:</span> {{ $siswa->kelas->nama_kelas ?? '-' }}</p>
            </div>
            <div>
                <p><span class="font-semibold">Alamat:</span> {{ $siswa->alamat }}</p>
                <p><span class="font-semibold">No. Telp:</span> {{ $siswa->no_telp }}</p>
                <p><span class="font-semibold">SPP Nominal:</span> Rp {{ number_format($siswa->spp->nominal ?? 0, 0, ',', '.') }}</p>
            </div>
        </div>
    </div>

    <div class="bg-white shadow rounded-lg p-6">
        <h2 class="text-xl font-semibold mb-4">Riwayat Pembayaran per Tahun</h2>

        @forelse($history as $year => $data)
            <div class="mb-6 p-4 border rounded-lg">
                <h3 class="text-lg font-bold mb-3">Tahun: {{ $year }}</h3>

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
            <p class="text-gray-600">Belum ada riwayat pembayaran untuk siswa ini.</p>
        @endforelse

    </div>

    <div class="mt-6">
        <a href="{{ route('admin.siswa.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-200 focus:ring-offset-2 transition ease-in-out duration-150">
            Kembali ke Data Siswa
        </a>
    </div>
</div>
@endsection 