<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin SPP</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass {
            background: rgba(30, 64, 175, 0.7);
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
            background: rgba(30, 41, 59, 0.5);
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
<body class="bg-gradient-to-br from-blue-100 via-indigo-100 to-purple-100 min-h-screen">
    <div class="min-h-screen flex flex-col">
        <!-- Navbar -->
        <header class="bg-white/80 shadow-lg sticky top-0 z-30 glass">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between h-16 items-center">
                <div class="flex items-center space-x-4">
                    <button id="sidebarToggle" class="md:hidden text-gray-600 hover:text-blue-600 focus:outline-none">
                        <i class="fas fa-bars fa-lg"></i>
                    </button>
                    <span class="text-blue-700 font-extrabold text-2xl tracking-wide drop-shadow">SPP Admin</span>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <img src="https://i.pravatar.cc/40?img=3" alt="Admin" class="w-9 h-9 rounded-full border-2 border-blue-400 shadow">
                        <span class="font-semibold text-gray-700 hidden sm:inline">Admin</span>
                    </div>
                    <a href="{{ url('/') }}" class="text-gray-600 hover:text-blue-600 px-3 py-2 rounded-md text-sm font-medium transition">Beranda</a>
                </div>
            </div>
        </header>

        <div class="flex-1 flex overflow-hidden">
            <!-- Sidebar Desktop -->
            <aside id="sidebar" class="glass bg-gradient-to-b from-blue-700/80 to-blue-900/80 text-white w-64 px-2 py-6 hidden md:block transition-all duration-300 h-screen fixed top-16 left-0 z-30 shadow-2xl">
                <nav class="space-y-2">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800/90' : '' }}">
                        <i class="fas fa-home mr-3 sidebar-icon"></i> <span class="sidebar-label">Dashboard</span>
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-800/90' : '' }}">
                        <i class="fas fa-users mr-3 sidebar-icon"></i> <span class="sidebar-label">Manajemen User</span>
                    </a>
                    <a href="{{ route('admin.kelas.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-800/90' : '' }}">
                        <i class="fas fa-chalkboard mr-3 sidebar-icon"></i> <span class="sidebar-label">Data Kelas</span>
                    </a>
                    <a href="{{ route('admin.spp.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.spp.*') ? 'bg-blue-800/90' : '' }}">
                        <i class="fas fa-money-bill-wave mr-3 sidebar-icon"></i> <span class="sidebar-label">Data SPP</span>
                    </a>
                    <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-800/90' : '' }}">
                        <i class="fas fa-user-graduate mr-3 sidebar-icon"></i> <span class="sidebar-label">Data Siswa</span>
                    </a>
                    <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-800/90' : '' }}">
                        <i class="fas fa-receipt mr-3 sidebar-icon"></i> <span class="sidebar-label">Pembayaran</span>
                    </a>
                    <a href="{{ route('admin.laporan') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.laporan') ? 'bg-blue-800/90' : '' }}">
                        <i class="fas fa-file-alt mr-3 sidebar-icon"></i> <span class="sidebar-label">Laporan</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="w-full flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200">
                            <i class="fas fa-sign-out-alt mr-3 sidebar-icon"></i> <span class="sidebar-label">Logout</span>
                        </button>
                    </form>
                    <button id="collapseSidebar" class="mt-8 w-full flex items-center justify-center text-blue-200 hover:text-white transition-all">
                        <i class="fas fa-angle-double-left"></i>
                    </button>
                </nav>
            </aside>

            <!-- Sidebar Mobile Overlay -->
            <div id="sidebarMobileOverlay" class="sidebar-mobile-overlay hidden md:hidden">
                <aside id="sidebarMobile" class="glass bg-gradient-to-b from-blue-700/90 to-blue-900/90 text-white w-64 px-2 py-6 h-full shadow-2xl sidebar-mobile relative">
                    <button id="closeSidebarMobile" class="absolute top-4 right-4 text-white text-2xl focus:outline-none hover:text-blue-200">
                        <i class="fas fa-times"></i>
                    </button>
                    <nav class="space-y-2 mt-8">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-800/90' : '' }}">
                            <i class="fas fa-home mr-3 sidebar-icon"></i> <span class="sidebar-label">Dashboard</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.users.*') ? 'bg-blue-800/90' : '' }}">
                            <i class="fas fa-users mr-3 sidebar-icon"></i> <span class="sidebar-label">Manajemen User</span>
                        </a>
                        <a href="{{ route('admin.kelas.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.kelas.*') ? 'bg-blue-800/90' : '' }}">
                            <i class="fas fa-chalkboard mr-3 sidebar-icon"></i> <span class="sidebar-label">Data Kelas</span>
                        </a>
                        <a href="{{ route('admin.spp.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.spp.*') ? 'bg-blue-800/90' : '' }}">
                            <i class="fas fa-money-bill-wave mr-3 sidebar-icon"></i> <span class="sidebar-label">Data SPP</span>
                        </a>
                        <a href="{{ route('admin.siswa.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-800/90' : '' }}">
                            <i class="fas fa-user-graduate mr-3 sidebar-icon"></i> <span class="sidebar-label">Data Siswa</span>
                        </a>
                        <a href="{{ route('admin.pembayaran.index') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.pembayaran.*') ? 'bg-blue-800/90' : '' }}">
                            <i class="fas fa-receipt mr-3 sidebar-icon"></i> <span class="sidebar-label">Pembayaran</span>
                        </a>
                        <a href="{{ route('admin.laporan') }}" class="flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200 {{ request()->routeIs('admin.laporan') ? 'bg-blue-800/90' : '' }}">
                            <i class="fas fa-file-alt mr-3 sidebar-icon"></i> <span class="sidebar-label">Laporan</span>
                        </a>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2 rounded-xl hover:bg-blue-800/80 hover:scale-105 transition-all duration-200">
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
            const collapse = document.getElementById('collapseSidebar');
            const sidebarMobileOverlay = document.getElementById('sidebarMobileOverlay');
            const sidebarMobile = document.getElementById('sidebarMobile');
            const closeSidebarMobile = document.getElementById('closeSidebarMobile');
            let collapsed = false;
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
            if(collapse) {
                collapse.addEventListener('click', function() {
                    collapsed = !collapsed;
                    document.body.classList.toggle('sidebar-collapsed', collapsed);
                    sidebar.classList.toggle('w-20', collapsed);
                    sidebar.classList.toggle('w-64', !collapsed);
                });
            }
        });
    </script>
    @yield('scripts')
</body>
</html> 