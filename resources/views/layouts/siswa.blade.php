<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Siswa SPP</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(99, 102, 241, 0.7);
            box-shadow: 0 8px 32px 0 rgba(31, 38, 135, 0.37);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border-radius: 16px;
            border: 1px solid rgba(255,255,255,0.18);
        }
        .sidebar-collapsed .sidebar-label { display: none; }
        .sidebar-collapsed .sidebar-icon { justify-content: center; }
        .sidebar-mobile-overlay {
            position: fixed;
            inset: 0;
            background: rgba(99, 102, 241, 0.5);
            z-index: 40;
            display: flex;
        }
        .sidebar-mobile {
            animation: slideInLeft 0.3s;
        }
        @keyframes slideInLeft {
            from { transform: translateX(-100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        .no-scroll {
            overflow: hidden !important;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <header class="bg-white/80 shadow-lg sticky top-0 z-30 glass">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggle" class="md:hidden text-gray-600 hover:text-indigo-600 focus:outline-none">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <span class="text-indigo-700 font-extrabold text-2xl tracking-wide drop-shadow">SPP Siswa</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <img src="https://i.pravatar.cc/40?img=8" alt="Siswa" class="w-9 h-9 rounded-full border-2 border-indigo-400 shadow">
                        <span class="font-semibold text-gray-700 hidden sm:inline">{{ Auth::user()->name ?? 'Siswa' }}</span>
                    </div>
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-indigo-600 px-3 py-2 rounded-md text-sm font-medium transition">Beranda</a>
                </div>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden">
            <!-- Sidebar Desktop -->
            <aside id="sidebar" class="glass bg-gradient-to-b from-indigo-500/90 to-purple-600/90 text-white w-64 px-2 py-6 hidden md:block transition-all duration-300 h-screen fixed top-16 left-0 z-30 shadow-2xl">
                <nav class="space-y-2">
                    <a href="{{ route('siswa.dashboard') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-indigo-700/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-700/90' : '' }}">
                        <i class="fas fa-home mr-3 sidebar-icon"></i> <span class="sidebar-label">Dashboard</span>
                    </a>
                    <a href="{{ route('siswa.history.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-indigo-700/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('siswa.history.*') ? 'bg-indigo-700/90' : '' }}">
                        <i class="fas fa-receipt mr-3 sidebar-icon"></i> <span class="sidebar-label">Riwayat Pembayaran</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2 rounded-xl hover:bg-indigo-700/80 hover:scale-105 transition-all duration-200">
                            <i class="fas fa-sign-out-alt mr-3 sidebar-icon"></i> <span class="sidebar-label">Logout</span>
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Sidebar Mobile Overlay -->
            <div id="sidebarMobileOverlay" class="sidebar-mobile-overlay hidden md:hidden">
                <aside id="sidebarMobile" class="glass bg-gradient-to-b from-indigo-500/90 to-purple-600/90 text-white w-64 px-2 py-6 h-full shadow-2xl sidebar-mobile relative">
                    <button id="closeSidebarMobile" class="absolute top-4 right-4 text-white text-2xl focus:outline-none hover:text-indigo-200">
                        <i class="fas fa-times"></i>
                    </button>
                    <nav class="space-y-2 mt-8">
                        <a href="{{ route('siswa.dashboard') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-indigo-700/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('siswa.dashboard') ? 'bg-indigo-700/90' : '' }}">
                            <i class="fas fa-home mr-3 sidebar-icon"></i> <span class="sidebar-label">Dashboard</span>
                        </a>
                        <a href="{{ route('siswa.history.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-indigo-700/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('siswa.history.*') ? 'bg-indigo-700/90' : '' }}">
                            <i class="fas fa-receipt mr-3 sidebar-icon"></i> <span class="sidebar-label">Riwayat Pembayaran</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 rounded-xl hover:bg-indigo-700/80 hover:scale-105 transition-all duration-200">
                                <i class="fas fa-sign-out-alt mr-3 sidebar-icon"></i> <span class="sidebar-label">Logout</span>
                            </button>
                        </form>
                    </nav>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="flex-1 overflow-auto ml-0 md:ml-64">
                <main class="py-8 px-4 sm:px-8 lg:px-12 max-w-7xl mx-auto">
                    <h1 class="text-2xl font-bold text-gray-900 mb-6 drop-shadow">@yield('title')</h1>
                    @yield('content')
                </main>
            </div>
        </div>
    </div>

    <script>
        // Sidebar toggle for mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const toggle = document.getElementById('sidebarToggle');
            const sidebarMobileOverlay = document.getElementById('sidebarMobileOverlay');
            const sidebarMobile = document.getElementById('sidebarMobile');
            const closeSidebarMobile = document.getElementById('closeSidebarMobile');
            if(toggle) {
                toggle.addEventListener('click', function() {
                    sidebarMobileOverlay.classList.remove('hidden');
                    document.body.classList.add('no-scroll');
                });
            }
            if(closeSidebarMobile) {
                closeSidebarMobile.addEventListener('click', function() {
                    sidebarMobileOverlay.classList.add('hidden');
                    document.body.classList.remove('no-scroll');
                });
            }
            // Klik di luar sidebar untuk menutup
            if(sidebarMobileOverlay) {
                sidebarMobileOverlay.addEventListener('click', function(e) {
                    if(e.target === sidebarMobileOverlay) {
                        sidebarMobileOverlay.classList.add('hidden');
                        document.body.classList.remove('no-scroll');
                    }
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html>