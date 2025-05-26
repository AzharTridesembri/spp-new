<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Pembayaran SPP') }}
            </h2>
            <a href="{{ route('petugas.dashboard') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                {{ __('Kembali') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-6">
                        <h3 class="font-semibold text-lg mb-4">Filter Laporan</h3>
                        <form action="{{ route('petugas.laporan') }}" method="GET" class="space-y-4">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                                    <input type="date" id="tanggal" name="tanggal" value="{{ $tanggal ?? '' }}" 
                                           class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                </div>
                                
                                <div>
                                    <label for="bulan" class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                                    <select id="bulan" name="bulan" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Semua Bulan</option>
                                        @foreach ($bulanList as $b)
                                            <option value="{{ $b }}" {{ ($bulan == $b) ? 'selected' : '' }}>{{ $b }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label for="tahun" class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                    <select id="tahun" name="tahun" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <option value="">Semua Tahun</option>
                                        @foreach ($tahunList as $t)
                                            <option value="{{ $t }}" {{ ($tahun == $t) ? 'selected' : '' }}>{{ $t }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="flex space-x-3">
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                    Filter Laporan
                                </button>
                                
                                @if(count($pembayaran) > 0)
                                <a href="{{ route('petugas.laporan', array_merge(request()->query(), ['preview' => 1])) }}" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                    <i class="fas fa-file-pdf mr-1"></i> Preview PDF
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="font-semibold text-lg mb-4">Hasil Laporan</h3>
                        @if(count($pembayaran) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full bg-white rounded-lg overflow-hidden">
                                    <thead class="bg-gray-100 text-gray-700">
                                        <tr>
                                            <th class="py-3 px-4 text-left">No</th>
                                            <th class="py-3 px-4 text-left">Petugas</th>
                                            <th class="py-3 px-4 text-left">Siswa</th>
                                            <th class="py-3 px-4 text-left">NISN</th>
                                            <th class="py-3 px-4 text-left">Kelas</th>
                                            <th class="py-3 px-4 text-left">Tanggal Bayar</th>
                                            <th class="py-3 px-4 text-left">Bulan/Tahun</th>
                                            <th class="py-3 px-4 text-left">Jumlah</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        @foreach ($pembayaran as $index => $item)
                                            <tr class="hover:bg-gray-50">
                                                <td class="py-3 px-4">{{ $index + 1 }}</td>
                                                <td class="py-3 px-4">{{ $item->user->name }}</td>
                                                <td class="py-3 px-4">{{ $item->siswa->nama }}</td>
                                                <td class="py-3 px-4">{{ $item->siswa->nisn }}</td>
                                                <td class="py-3 px-4">{{ $item->siswa->kelas->nama_kelas }}</td>
                                                <td class="py-3 px-4">{{ date('d/m/Y', strtotime($item->tanggal_bayar)) }}</td>
                                                <td class="py-3 px-4">{{ $item->bulan_dibayar }}/{{ $item->tahun_dibayar }}</td>
                                                <td class="py-3 px-4">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot class="bg-gray-50">
                                        <tr>
                                            <td colspan="7" class="py-3 px-4 text-right font-medium">Total Pembayaran:</td>
                                            <td class="py-3 px-4 font-bold text-green-600">
                                                Rp {{ number_format($pembayaran->sum('jumlah_bayar'), 0, ',', '.') }}
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        @else
                            <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-md">
                                Tidak ada data pembayaran yang ditemukan dengan filter yang dipilih.
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 