@extends('layouts.admin')

@section('title', 'Edit Data Siswa')

@section('content')
<div class="max-w-2xl mx-auto bg-white rounded-2xl shadow-lg p-8 mt-10 border border-gray-100">
    <div class="flex items-center mb-8">
        <div class="bg-blue-100 text-blue-600 rounded-full p-3 mr-4">
            <i class="fas fa-user-graduate fa-lg"></i>
        </div>
        <div>
            <h2 class="text-2xl font-bold">Edit Data Siswa</h2>
            <p class="text-gray-500 text-sm">Perbarui data siswa dengan teliti dan aman.</p>
        </div>
    </div>
    <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="nisn" class="block text-gray-700 font-semibold mb-1">NISN</label>
                <input type="text" name="nisn" id="nisn" value="{{ old('nisn', $siswa->nisn) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('nisn') border-red-500 @enderror" required>
                @error('nisn')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="nis" class="block text-gray-700 font-semibold mb-1">NIS</label>
                <input type="text" name="nis" id="nis" value="{{ old('nis', $siswa->nis) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('nis') border-red-500 @enderror" required>
                @error('nis')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div>
            <label for="nama" class="block text-gray-700 font-semibold mb-1">Nama</label>
            <input type="text" name="nama" id="nama" value="{{ old('nama', $siswa->nama) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('nama') border-red-500 @enderror" required>
            @error('nama')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $siswa->user->email ?? '') }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('email') border-red-500 @enderror" required>
            @error('email')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="kelas_id" class="block text-gray-700 font-semibold mb-1">Kelas</label>
                <select name="kelas_id" id="kelas_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('kelas_id') border-red-500 @enderror" required>
                    <option value="">Pilih Kelas</option>
                    @foreach($kelas as $k)
                        <option value="{{ $k->id }}" {{ old('kelas_id', $siswa->kelas_id) == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                @error('kelas_id')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="spp_id" class="block text-gray-700 font-semibold mb-1">SPP</label>
                <select name="spp_id" id="spp_id" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('spp_id') border-red-500 @enderror" required>
                    <option value="">Pilih SPP</option>
                    @foreach($spps as $spp)
                        <option value="{{ $spp->id }}" {{ old('spp_id', $siswa->spp_id) == $spp->id ? 'selected' : '' }}>{{ $spp->tahun }} - Rp {{ number_format($spp->nominal,0,',','.') }}</option>
                    @endforeach
                </select>
                @error('spp_id')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div>
            <label for="alamat" class="block text-gray-700 font-semibold mb-1">Alamat</label>
            <input type="text" name="alamat" id="alamat" value="{{ old('alamat', $siswa->alamat) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('alamat') border-red-500 @enderror" required>
            @error('alamat')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="no_telp" class="block text-gray-700 font-semibold mb-1">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp" value="{{ old('no_telp', $siswa->no_telp) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('no_telp') border-red-500 @enderror" required>
            @error('no_telp')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password" class="block text-gray-700 font-semibold mb-1">Password (kosongkan jika tidak ingin mengubah)</label>
            <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('password') border-red-500 @enderror">
            @error('password')
                <span class="text-red-500 text-xs">{{ $message }}</span>
            @enderror
        </div>
        <div>
            <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
        </div>
        <div class="flex justify-end gap-2 mt-6">
            <a href="{{ route('admin.siswa.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-5 rounded-lg border border-gray-300 transition">Batal</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                <i class="fas fa-save"></i> Simpan
            </button>
        </div>
    </form>
</div>
@endsection 