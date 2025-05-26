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
        <!-- Animate.css -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-gradient-to-br from-indigo-300 via-purple-100 to-pink-200 font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex items-center justify-center p-4">
            <!-- Container untuk desktop -->
            <div class="hidden md:flex w-full max-w-6xl bg-white/80 backdrop-blur-lg shadow-2xl rounded-3xl overflow-hidden animate__animated animate__fadeIn">
                <!-- Kolom Kiri - Ilustrasi -->
                <div class="w-1/2 bg-gradient-to-br from-indigo-500 to-purple-600 p-12 flex flex-col justify-center items-center text-white relative overflow-hidden">
                    <!-- Animated Background Elements -->
                    <div class="absolute inset-0 overflow-hidden">
                        <div class="absolute -top-10 -left-10 w-40 h-40 bg-white/10 rounded-full blur-2xl animate-pulse"></div>
                        <div class="absolute top-1/2 -right-10 w-60 h-60 bg-white/10 rounded-full blur-2xl animate-pulse" style="animation-delay: 1s"></div>
                        <div class="absolute -bottom-10 left-1/3 w-40 h-40 bg-white/10 rounded-full blur-2xl animate-pulse" style="animation-delay: 2s"></div>
                    </div>
                    
                    <div class="text-center relative z-10">
                        <div class="bg-white/20 rounded-full p-8 mb-6 backdrop-blur-sm transform hover:scale-110 transition-transform duration-300">
                            <i class="fas fa-graduation-cap text-6xl animate__animated animate__bounceIn"></i>
                        </div>
                        <h1 class="text-4xl font-bold mb-4 animate__animated animate__fadeInDown">SPP App</h1>
                        <p class="text-lg opacity-90 animate__animated animate__fadeInUp">Sistem Pembayaran SPP Online</p>
                        <div class="mt-12 flex flex-col items-center">
                            <div class="bg-white/20 rounded-full p-8 mb-4 backdrop-blur-sm transform hover:scale-110 transition-transform duration-300">
                                <i class="fas fa-user-graduate text-7xl animate__animated animate__bounceIn"></i>
                            </div>
                            <div class="flex space-x-4">
                                <div class="bg-white/20 rounded-full p-4 backdrop-blur-sm transform hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-book text-3xl animate__animated animate__bounceIn" style="animation-delay: 0.2s"></i>
                                </div>
                                <div class="bg-white/20 rounded-full p-4 backdrop-blur-sm transform hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-money-bill-wave text-3xl animate__animated animate__bounceIn" style="animation-delay: 0.4s"></i>
                                </div>
                                <div class="bg-white/20 rounded-full p-4 backdrop-blur-sm transform hover:scale-110 transition-transform duration-300">
                                    <i class="fas fa-chart-line text-3xl animate__animated animate__bounceIn" style="animation-delay: 0.6s"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Kolom Kanan - Form Login -->
                <div class="w-1/2 p-12 flex items-center bg-white/90 backdrop-blur-sm">
                    <div class="w-full animate__animated animate__fadeInRight">
                        <h2 class="text-3xl font-bold text-indigo-700 mb-2">Login SPP</h2>
                        <p class="text-gray-600 mb-8">Login dengan <b>email</b> (admin/petugas) atau <b>NISN</b> (siswa)</p>
                        
                        @if(session('status'))
                            <div class="mb-4 text-green-600 font-medium animate__animated animate__fadeIn">{{ session('status') }}</div>
                        @endif
                        @if($errors->any())
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded animate__animated animate__shakeX">
                                <ul class="list-disc pl-5">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}" class="space-y-6">
                            @csrf
                            <div class="relative group">
                                <label for="login" class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-indigo-600 transition-colors">Email atau NISN</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-hover:text-indigo-600 transition-colors">
                                        <i class="fas fa-user"></i>
                                    </span>
                                    <input id="login" name="login" type="text" required autofocus placeholder="Masukkan email atau NISN" 
                                        class="h-12 w-full pl-10 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm transition-all duration-300 hover:shadow-md" 
                                        value="{{ old('login') }}">
                                </div>
                            </div>
                            <div class="relative group">
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-indigo-600 transition-colors">Password</label>
                                <div class="relative">
                                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-hover:text-indigo-600 transition-colors">
                                        <i class="fas fa-lock"></i>
                                    </span>
                                    <input id="password" name="password" type="password" required placeholder="Masukkan password" 
                                        class="h-12 w-full pl-10 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm transition-all duration-300 hover:shadow-md">
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center group">
                                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors" name="remember">
                                    <label for="remember_me" class="ms-2 text-sm text-gray-600 group-hover:text-indigo-600 transition-colors">Ingat saya</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline transition-colors" href="{{ route('password.request') }}">
                                        Lupa password?
                                    </a>
                                @endif
                            </div>
                            <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold shadow-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 text-lg tracking-wide transform hover:scale-[1.02] hover:shadow-xl">
                                <span class="flex items-center justify-center">
                                    <i class="fas fa-sign-in-alt mr-2"></i>
                                    Login
                                </span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Tampilan Mobile (yang sudah ada) -->
            <div class="md:hidden w-full flex flex-col items-center justify-center animate__animated animate__fadeIn">
                <!-- Logo/Branding di atas card -->
                <div class="mb-8 flex flex-col items-center">
                    <div class="bg-white/90 shadow-lg rounded-full p-5 mb-2 border-4 border-indigo-200 transform hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-graduation-cap text-indigo-600 text-5xl animate__animated animate__bounceIn"></i>
                    </div>
                    <span class="text-3xl font-extrabold text-indigo-700 tracking-wide drop-shadow animate__animated animate__fadeInDown">SPP App</span>
                </div>
                <!-- Card Login -->
                <div class="w-full max-w-md mx-auto bg-white/60 backdrop-blur-lg shadow-2xl rounded-2xl p-10 border border-indigo-100">
                    <h2 class="text-2xl font-bold text-indigo-700 mb-2 text-center animate__animated animate__fadeIn">Login SPP</h2>
                    <p class="text-gray-500 text-xs mb-8 text-center animate__animated animate__fadeIn">Login dengan <b>email</b> (admin/petugas) atau <b>NISN</b> (siswa)</p>
                    @if(session('status'))
                        <div class="mb-4 text-green-600 font-medium animate__animated animate__fadeIn">{{ session('status') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded animate__animated animate__shakeX">
                            <ul class="list-disc pl-5">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf
                        <div class="relative group">
                            <label for="login" class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-indigo-600 transition-colors">Email atau NISN</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <i class="fas fa-user"></i>
                                </span>
                                <input id="login" name="login" type="text" required autofocus placeholder="Masukkan email atau NISN" 
                                    class="h-12 w-full pl-10 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm transition-all duration-300 hover:shadow-md" 
                                    value="{{ old('login') }}">
                            </div>
                        </div>
                        <div class="relative group">
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1 group-hover:text-indigo-600 transition-colors">Password</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400 group-hover:text-indigo-600 transition-colors">
                                    <i class="fas fa-lock"></i>
                                </span>
                                <input id="password" name="password" type="password" required placeholder="Masukkan password" 
                                    class="h-12 w-full pl-10 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 shadow-sm transition-all duration-300 hover:shadow-md">
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="flex items-center group">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 transition-colors" name="remember">
                                <label for="remember_me" class="ms-2 text-sm text-gray-600 group-hover:text-indigo-600 transition-colors">Ingat saya</label>
                            </div>
                            @if (Route::has('password.request'))
                                <a class="text-sm text-indigo-600 hover:text-indigo-800 hover:underline transition-colors" href="{{ route('password.request') }}">
                                    Lupa password?
                                </a>
                            @endif
                        </div>
                        <button type="submit" class="w-full py-3 px-4 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl font-bold shadow-lg hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 text-lg tracking-wide transform hover:scale-[1.02] hover:shadow-xl">
                            <span class="flex items-center justify-center">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Login
                            </span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
