@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
<div class="flex justify-center items-start min-h-[60vh] w-full">
    <div class="w-full max-w-3xl bg-white rounded-2xl shadow-lg p-8 mt-10 border border-gray-100">
        <div class="flex items-center mb-8">
            <div class="bg-blue-100 text-blue-600 rounded-full p-3 mr-4">
                <i class="fas fa-user-edit fa-lg"></i>
            </div>
            <div>
                <h2 class="text-2xl font-bold">Edit User</h2>
                <p class="text-gray-500 text-sm">Perbarui data user dengan teliti dan aman.</p>
            </div>
        </div>
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label for="name" class="block text-gray-700 font-semibold mb-1">Nama</label>
                <div class="relative">
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('name') border-red-500 @enderror" required>
                    <span class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-user"></i></span>
                </div>
                @error('name')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                <div class="relative">
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('email') border-red-500 @enderror" required>
                    <span class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-envelope"></i></span>
                </div>
                @error('email')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="role" class="block text-gray-700 font-semibold mb-1">Role</label>
                <select name="role" id="role" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('role') border-red-500 @enderror" required>
                    @foreach($roles as $key => $label)
                        <option value="{{ $key }}" {{ old('role', $user->role) == $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('role')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-gray-700 font-semibold mb-1">Password <span class="text-xs text-gray-400">(kosongkan jika tidak ingin mengubah)</span></label>
                <div class="relative">
                    <input type="password" name="password" id="password" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition @error('password') border-red-500 @enderror">
                    <span class="absolute right-3 top-2.5 text-gray-400"><i class="fas fa-lock"></i></span>
                </div>
                @error('password')
                    <span class="text-red-500 text-xs">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-blue-400 transition">
            </div>
            <div class="flex justify-end gap-2 mt-6">
                <a href="{{ route('admin.users.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-2 px-5 rounded-lg border border-gray-300 transition">Batal</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg shadow transition flex items-center gap-2">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection 