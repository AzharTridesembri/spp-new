@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <!-- Total Siswa Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
        <div class="rounded-full bg-blue-100 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-blue-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v1h8v-1zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-1a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v1h-3zM4.75 12.094A5.973 5.973 0 004 15v1H1v-1a3 3 0 013.75-2.906z" />
            </svg>
        </div>
        <div class="ml-4">
            <h2 class="text-gray-600 text-sm font-medium uppercase">Total Siswa</h2>
            <p class="text-gray-900 text-2xl font-semibold">{{ $totalSiswa }}</p>
        </div>
    </div>
    
    <!-- Total Kelas Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
        <div class="rounded-full bg-green-100 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
            </svg>
        </div>
        <div class="ml-4">
            <h2 class="text-gray-600 text-sm font-medium uppercase">Total Kelas</h2>
            <p class="text-gray-900 text-2xl font-semibold">{{ $totalKelas }}</p>
        </div>
    </div>
    
    <!-- Total Petugas Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
        <div class="rounded-full bg-yellow-100 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-yellow-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
            </svg>
        </div>
        <div class="ml-4">
            <h2 class="text-gray-600 text-sm font-medium uppercase">Total Petugas</h2>
            <p class="text-gray-900 text-2xl font-semibold">{{ $totalPetugas }}</p>
        </div>
    </div>
    
    <!-- Total Pembayaran Card -->
    <div class="bg-white rounded-lg shadow p-6 flex items-center">
        <div class="rounded-full bg-purple-100 p-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-purple-600" viewBox="0 0 20 20" fill="currentColor">
                <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z" />
                <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd" />
            </svg>
        </div>
        <div class="ml-4">
            <h2 class="text-gray-600 text-sm font-medium uppercase">Total Pembayaran</h2>
            <p class="text-gray-900 text-2xl font-semibold">Rp {{ number_format($totalPembayaran, 0, ',', '.') }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Chart -->
    <div class="bg-white rounded-lg shadow lg:col-span-2">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Statistik Pembayaran Tahun {{ date('Y') }}</h2>
            <div id="paymentChart" style="height: 300px;"></div>
        </div>
    </div>
    
    <!-- Recent Payments -->
    <div class="bg-white rounded-lg shadow">
        <div class="p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-4">Pembayaran Terbaru</h2>
            <div class="space-y-4">
                @forelse($recentPayments as $payment)
                <div class="flex items-start">
                    <div class="rounded-full bg-gray-100 p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3 flex-1">
                        <div class="flex justify-between items-center">
                            <p class="text-sm font-medium text-gray-900">{{ $payment->siswa->nama }}</p>
                            <p class="text-xs text-gray-500">{{ $payment->created_at->diffForHumans() }}</p>
                        </div>
                        <p class="text-sm text-gray-600">Rp {{ number_format($payment->jumlah_bayar, 0, ',', '.') }} - {{ $payment->bulan_dibayar }} {{ $payment->tahun_dibayar }}</p>
                        <p class="text-xs text-gray-500">Oleh: {{ $payment->user->name }}</p>
                    </div>
                </div>
                @empty
                <p class="text-sm text-gray-500">Belum ada pembayaran</p>
                @endforelse
            </div>
            
            <div class="mt-4 text-center">
                <a href="{{ route('admin.pembayaran.index') }}" class="text-sm text-indigo-600 hover:text-indigo-900">Lihat Semua Pembayaran</a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
        const monthlyData = @json($monthlyPayments);
        
        // Prepare chart data
        const categories = [];
        const series = [];
        
        // Initialize all months with 0
        for (let i = 1; i <= 12; i++) {
            categories.push(monthNames[i-1]);
            series.push(0);
        }
        
        // Fill in actual data
        monthlyData.forEach(item => {
            const monthIndex = item.month - 1;
            series[monthIndex] = parseInt(item.total);
        });
        
        // Create chart
        const options = {
            chart: {
                type: 'area',
                height: 300,
                toolbar: {
                    show: false
                }
            },
            series: [{
                name: 'Pembayaran',
                data: series
            }],
            xaxis: {
                categories: categories
            },
            yaxis: {
                labels: {
                    formatter: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            },
            colors: ['#6366f1'],
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.2,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                y: {
                    formatter: function(value) {
                        return 'Rp ' + value.toLocaleString('id-ID');
                    }
                }
            }
        };
        
        const chart = new ApexCharts(document.querySelector('#paymentChart'), options);
        chart.render();
    });
</script>
@endsection 