@extends('layouts.admin')

@section('title', 'Data Siswa')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 flex flex-col md:flex-row md:justify-between md:items-center border-b gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Siswa</h2>
        <div class="flex items-center space-x-2">
            <form action="{{ route('admin.siswa.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari siswa..." class="form-input rounded-md shadow-sm mt-1 block w-full md:w-auto">
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                    <i class="fas fa-search"></i> Cari
                </button>
            </form>
            <a href="{{ route('admin.siswa.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
                <i class="fas fa-user-plus"></i> <span class="hidden sm:inline">Tambah Siswa</span>
            </a>
        </div>
    </div>
    @if(session('success'))
    <div class="m-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif
    @if(session('error'))
    <div class="m-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
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
                <tr class="hover:bg-blue-50 transition">
                    <td class="py-3 px-4">{{ $siswas->firstItem() + $index }}</td>
                    <td class="py-3 px-4 font-semibold text-blue-700">{{ $siswa->nama }}</td>
                    <td class="py-3 px-4">{{ $siswa->nis }}</td>
                    <td class="py-3 px-4 hidden md:table-cell">{{ $siswa->nisn }}</td>
                    <td class="py-3 px-4 hidden lg:table-cell">{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="py-3 px-4 hidden md:table-cell">{{ $siswa->alamat }}</td>
                    <td class="py-3 px-4 hidden md:table-cell">{{ $siswa->no_telp }}</td>
                    <td class="py-3 px-4 flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.siswa.edit', $siswa->id) }}" class="p-2 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="{{ route('admin.siswa.paymentHistory', $siswa->id) }}" class="p-2 bg-blue-100 text-blue-700 rounded hover:bg-blue-200" title="Lihat Riwayat Pembayaran">
                            <i class="fas fa-history"></i>
                        </a>
                        <form action="{{ route('admin.siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus siswa ini?')" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200" title="Hapus">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
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