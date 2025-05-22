<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pembayaran SPP</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex flex-col items-center justify-center min-h-screen p-4">
        <div class="w-full max-w-md bg-white rounded-lg shadow-md p-8 mb-8">
            <h1 class="text-3xl font-bold text-center text-blue-600 mb-2">Aplikasi Pembayaran SPP</h1>
            <p class="text-gray-600 text-center mb-8">Sistem Informasi Pembayaran SPP Sekolah</p>
            
            <div class="flex flex-col space-y-4 items-center">
                <a href="{{ route('admin.dashboard') }}" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded text-center">
                    Akses sebagai Admin
                </a>
                
                <a href="{{ route('petugas.dashboard') }}" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-6 rounded text-center">
                    Akses sebagai Petugas
                </a>
                
                <a href="{{ route('siswa.dashboard') }}" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded text-center">
                    Akses sebagai Siswa
                </a>
            </div>
        </div>
        
        <div class="text-center text-gray-500 text-sm">
            &copy; 2025 Aplikasi Pembayaran SPP
        </div>
    </div>
</body>
</html> 