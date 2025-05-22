@extends('layouts.admin')

@section('title', 'Daftar Kelas')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 flex flex-col md:flex-row md:justify-between md:items-center border-b gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Daftar Kelas</h2>
        <a href="{{ route('admin.kelas.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2">
            <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Kelas</span>
        </a>
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
                    <th class="py-3 px-4 text-left whitespace-nowrap">Nama Kelas</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Kompetensi Keahlian</th>
                    <th class="py-3 px-4 text-center whitespace-nowrap">Jumlah Siswa</th>
                    <th class="py-3 px-4 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-gray-600 divide-y">
                @forelse($kelas as $key => $item)
                    <tr class="hover:bg-blue-50 transition">
                    <td class="py-4 px-4">{{ $key + 1 }}</td>
                    <td class="py-4 px-4 font-semibold text-blue-700">{{ $item->nama_kelas }}</td>
                    <td class="py-4 px-4">{{ $item->kompetensi_keahlian }}</td>
                    <td class="py-4 px-4 text-center">{{ $item->siswa_count ?? $item->siswa->count() }}</td>
                    <td class="py-4 px-4 flex items-center justify-center space-x-2">
                        <a href="{{ route('admin.kelas.show', $item->id) }}" class="p-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200" title="Detail">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.kelas.edit', $item->id) }}" class="p-2 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.kelas.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data kelas ini?')">
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
                    <td colspan="5" class="py-4 px-4 text-center text-gray-500">Tidak ada data Kelas</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 