<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pembayaran SPP') }}
            </h2>
            <a href="{{ route('admin.pembayaran.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                {{ __('Kembali') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold border-b pb-2 mb-4">Informasi Pembayaran</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600">Petugas</p>
                                    <p class="text-base">{{ $pembayaran->user->name }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600">Tanggal Bayar</p>
                                    <p class="text-base">{{ date('d F Y', strtotime($pembayaran->tanggal_bayar)) }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600">Bulan/Tahun Dibayar</p>
                                    <p class="text-base">{{ $pembayaran->bulan_dibayar }} {{ $pembayaran->tahun_dibayar }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600">Jumlah Bayar</p>
                                    <p class="text-base font-semibold text-green-600">Rp {{ number_format($pembayaran->jumlah_bayar, 0, ',', '.') }}</p>
                                </div>
                            </div>

                            <div>
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600">Nama Siswa</p>
                                    <p class="text-base">{{ $pembayaran->siswa->nama }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600">NISN/NIS</p>
                                    <p class="text-base">{{ $pembayaran->siswa->nisn }} / {{ $pembayaran->siswa->nis }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600">Kelas</p>
                                    <p class="text-base">{{ $pembayaran->siswa->kelas->nama_kelas }}</p>
                                </div>
                                
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-600">Nominal SPP</p>
                                    <p class="text-base">Rp {{ number_format($pembayaran->siswa->spp->nominal, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex space-x-4">
                        <a href="{{ route('admin.pembayaran.edit', $pembayaran->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                            {{ __('Edit') }}
                        </a>
                        <form action="{{ route('admin.pembayaran.destroy', $pembayaran->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pembayaran ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition">
                                {{ __('Hapus') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 