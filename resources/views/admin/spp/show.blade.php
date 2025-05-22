@extends('layouts.admin')

@section('title', 'Detail SPP')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 flex justify-between items-center border-b">
        <h2 class="text-xl font-semibold text-gray-800">Detail SPP</h2>
        <div class="flex space-x-2">
            <a href="{{ route('admin.spp.edit', $spp->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 focus:outline-none focus:bg-yellow-600 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Edit
            </a>
            <a href="{{ route('admin.spp.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 focus:outline-none focus:bg-gray-600">
                Kembali
            </a>
        </div>
    </div>
    
    <div class="p-6 border-b">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Informasi SPP</h3>
                <table class="w-full">
                    <tr class="border-b">
                        <td class="py-3 text-gray-600">Tahun</td>
                        <td class="py-3 font-medium">{{ $spp->tahun }}</td>
                    </tr>
                    <tr class="border-b">
                        <td class="py-3 text-gray-600">Nominal</td>
                        <td class="py-3 font-medium">Rp {{ number_format($spp->nominal, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="py-3 text-gray-600">Jumlah Siswa</td>
                        <td class="py-3 font-medium">{{ $spp->siswa->count() }} Siswa</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <div class="p-6">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Daftar Siswa dengan SPP Ini</h3>
        <div class="overflow-x-auto">
            <table class="w-full table-auto">
                <thead class="bg-gray-50 text-gray-600 text-sm font-semibold uppercase">
                    <tr>
                        <th class="py-3 px-6 text-left">No</th>
                        <th class="py-3 px-6 text-left">NISN</th>
                        <th class="py-3 px-6 text-left">NIS</th>
                        <th class="py-3 px-6 text-left">Nama</th>
                        <th class="py-3 px-6 text-left">Kelas</th>
                        <th class="py-3 px-6 text-left">No. Telp</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 divide-y">
                    @forelse($spp->siswa as $key => $siswa)
                    <tr class="hover:bg-gray-50">
                        <td class="py-4 px-6">{{ $key + 1 }}</td>
                        <td class="py-4 px-6">{{ $siswa->nisn }}</td>
                        <td class="py-4 px-6">{{ $siswa->nis }}</td>
                        <td class="py-4 px-6">{{ $siswa->nama }}</td>
                        <td class="py-4 px-6">{{ $siswa->kelas->nama_kelas }}</td>
                        <td class="py-4 px-6">{{ $siswa->no_telp }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 px-6 text-center text-gray-500">Tidak ada siswa yang menggunakan SPP ini</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection 