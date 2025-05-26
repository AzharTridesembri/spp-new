{{-- @extends('layouts.petugas')

@section('title', __('Data Siswa'))

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white rounded-lg overflow-hidden">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="py-3 px-4 text-left">No</th>
                                    <th class="py-3 px-4 text-left">NISN</th>
                                    <th class="py-3 px-4 text-left">NIS</th>
                                    <th class="py-3 px-4 text-left">Nama</th>
                                    <th class="py-3 px-4 text-left">Kelas</th>
                                    <th class="py-3 px-4 text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($siswas as $index => $siswa)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-3 px-4">{{ $index + $siswas->firstItem() }}</td>
                                        <td class="py-3 px-4">{{ $siswa->nisn }}</td>
                                        <td class="py-3 px-4">{{ $siswa->nis }}</td>
                                        <td class="py-3 px-4">{{ $siswa->nama }}</td>
                                        <td class="py-3 px-4">{{ $siswa->kelas->nama_kelas }}</td>
                                        <td class="py-3 px-4">
                                            <a href="{{ route('petugas.siswa.paymentHistory', $siswa) }}" class="text-indigo-600 hover:text-indigo-900">
                                                Lihat Riwayat Pembayaran
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada data siswa.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $siswas->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection  --}}

@extends('layouts.petugas')

@section('title', 'Data Siswa')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 flex flex-col md:flex-row md:justify-between md:items-center border-b gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Siswa</h2>
        <div class="flex items-center space-x-2">
            <form action="{{ route('petugas.siswa.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari siswa..." class="form-input rounded-md shadow-sm mt-1 block w-full md:w-auto">
                <button type="submit" class="bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>
        </div>
    </div>
    @if(session('success'))
    <div class="m-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        {{ session('success') }}
    </div>
    @endif
    <div class="overflow-x-auto p-0 md:p-6">
        <table class="min-w-full bg-white rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700 sticky top-0 z-10">
                <tr>
                    <th class="py-3 px-4 text-left whitespace-nowrap">No</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Nama</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">NIS</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap hidden md:table-cell">NISN</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap hidden lg:table-cell">Kelas</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap hidden md:table-cell">Alamat</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap hidden md:table-cell">No. Telp</th>
                    <th class="py-3 px-4 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $index => $siswa)
                <tr class="hover:bg-emerald-50 transition">
                    <td class="py-3 px-4">{{ $siswas->firstItem() + $index }}</td>
                    <td class="py-3 px-4 font-semibold text-emerald-700">{{ $siswa->nama }}</td>
                    <td class="py-3 px-4">{{ $siswa->nis }}</td>
                    <td class="py-3 px-4 hidden md:table-cell">{{ $siswa->nisn }}</td>
                    <td class="py-3 px-4 hidden lg:table-cell">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="py-3 px-4 hidden md:table-cell">{{ $siswa->alamat }}</td>
                    <td class="py-3 px-4 hidden md:table-cell">{{ $siswa->no_telp }}</td>
                    <td class="py-3 px-4 flex items-center justify-center space-x-2">
                        <a href="{{ route('petugas.siswa.paymentHistory', $siswa->id) }}" class="p-2 bg-emerald-100 text-emerald-700 rounded hover:bg-emerald-200" title="Lihat Riwayat Pembayaran">
                            <i class="fas fa-history"></i>  
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-4 px-4 text-center text-gray-500">Belum ada data siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-4">
            {{ $siswas->links() }}
        </div>
    </div>
</div>
@endsection 