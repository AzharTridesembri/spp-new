<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <!-- FontAwesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-300 via-purple-100 to-pink-200 font-sans text-gray-900 antialiased">
        <div class="w-full flex flex-col items-center justify-center">
            <!-- Logo/Branding di atas card -->
            <div class="mb-8 flex flex-col items-center">
                <div class="bg-white/90 shadow-lg rounded-full p-5 mb-2 border-4 border-indigo-200">
                    <i class="fas fa-graduation-cap text-indigo-600 text-5xl"></i>
                </div>
                <span class="text-3xl font-extrabold text-indigo-700 tracking-wide drop-shadow">SPP App</span>
            </div>
            <!-- Card Login -->
            <div class="w-full max-w-md mx-auto bg-white/60 backdrop-blur-lg shadow-2xl rounded-2xl p-10 border border-indigo-100">
                <h2 class="text-2xl font-bold text-indigo-700 mb-2 text-center">Login SPP</h2>
                <p class="text-gray-500 text-xs mb-8 text-center">Login dengan <b>email</b> (admin/petugas) atau <b>NISN</b> (siswa)</p>
                @if(session('status'))
                    <div class="mb-4 text-green-600 font-medium">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                        <ul class="list-disc pl-5">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    <div class="relative">
                        <label for="login" class="block text-sm font-medium text-gray-700 mb-1">Email atau NISN</label>
                        <input id="login" name="login" type="text" required autofocus placeholder="Masukkan email atau NISN" class="h-12 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm transition" value="{{ old('login') }}">
                    </div>
                    <div class="relative">
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input id="password" name="password" type="password" required placeholder="Masukkan password" class="h-12 w-full rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm transition">
                    </div>
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                            <label for="remember_me" class="ms-2 text-sm text-gray-600">Ingat saya</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a class="text-sm text-indigo-600 hover:underline" href="{{ route('password.request') }}">
                                Lupa password?
                            </a>
                        @endif
                    </div>
                    <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold shadow-lg hover:from-indigo-700 hover:to-purple-700 transition text-lg tracking-wide">Login</button>
                </form>
            </div>
        </div>
    </body>
</html>
