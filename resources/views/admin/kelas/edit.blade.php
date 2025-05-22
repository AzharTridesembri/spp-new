@extends('layouts.admin')

@section('title', 'Edit Kelas')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Edit Kelas</h2>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.kelas.update', $kelas->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label for="nama_kelas" class="block text-sm font-medium text-gray-700 mb-2">Nama Kelas</label>
                <input type="text" name="nama_kelas" id="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" 
                    class="w-full px-3 py-2 border @error('nama_kelas') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Contoh: X RPL 1" required>
                @error('nama_kelas')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Maksimal 10 karakter</p>
            </div>
            
            <div class="mb-6">
                <label for="kompetensi_keahlian" class="block text-sm font-medium text-gray-700 mb-2">Kompetensi Keahlian</label>
                <input type="text" name="kompetensi_keahlian" id="kompetensi_keahlian" value="{{ old('kompetensi_keahlian', $kelas->kompetensi_keahlian) }}" 
                    class="w-full px-3 py-2 border @error('kompetensi_keahlian') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                @error('kompetensi_keahlian')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Maksimal 50 karakter</p>
            </div>
            
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.kelas.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:bg-gray-400">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 