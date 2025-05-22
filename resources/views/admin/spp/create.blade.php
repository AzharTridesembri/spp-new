@extends('layouts.admin')

@section('title', 'Tambah SPP')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 border-b">
        <h2 class="text-xl font-semibold text-gray-800">Tambah Data SPP</h2>
    </div>
    
    <div class="p-6">
        <form action="{{ route('admin.spp.store') }}" method="POST">
            @csrf
            
            <div class="mb-6">
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                <input type="number" name="tahun" id="tahun" value="{{ old('tahun') }}" 
                    class="w-full px-3 py-2 border @error('tahun') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Contoh: 2025" required>
                @error('tahun')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Masukkan tahun ajaran dengan 4 digit angka</p>
            </div>
            
            <div class="mb-6">
                <label for="nominal" class="block text-sm font-medium text-gray-700 mb-2">Nominal (Rp)</label>
                <input type="number" name="nominal" id="nominal" value="{{ old('nominal') }}" 
                    class="w-full px-3 py-2 border @error('nominal') border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Contoh: 1500000" required>
                @error('nominal')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                <p class="text-gray-500 text-xs mt-1">Masukkan nominal tanpa tanda titik atau koma. Minimal Rp 1.000</p>
            </div>
            
            <div class="flex items-center justify-end space-x-3">
                <a href="{{ route('admin.spp.index') }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-md hover:bg-gray-400 focus:outline-none focus:bg-gray-400">
                    Batal
                </a>
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 focus:outline-none focus:bg-indigo-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 