<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Pembayaran SPP') }}
            </h2>
            <a href="{{ route('admin.pembayaran.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition">
                {{ __('Kembali') }}
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    <form action="{{ route('admin.pembayaran.update', $pembayaran->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-1">Siswa *</label>
                                <select id="siswa_id" name="siswa_id" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('siswa_id') border-red-500 @enderror" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach($siswa as $s)
                                        <option value="{{ $s->id }}" data-spp="{{ $s->spp->nominal }}" {{ (old('siswa_id', $pembayaran->siswa_id) == $s->id) ? 'selected' : '' }}>
                                            {{ $s->nama }} - {{ $s->nisn }} - Kelas {{ $s->kelas->nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('siswa_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bayar *</label>
                                <input type="date" id="tanggal_bayar" name="tanggal_bayar" value="{{ old('tanggal_bayar', $pembayaran->tanggal_bayar) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('tanggal_bayar') border-red-500 @enderror" required>
                                @error('tanggal_bayar')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="bulan_dibayar" class="block text-sm font-medium text-gray-700 mb-1">Bulan Dibayar *</label>
                                <select id="bulan_dibayar" name="bulan_dibayar" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('bulan_dibayar') border-red-500 @enderror" required>
                                    <option value="">Pilih Bulan</option>
                                    @foreach($bulan as $b)
                                        <option value="{{ $b }}" {{ (old('bulan_dibayar', $pembayaran->bulan_dibayar) == $b) ? 'selected' : '' }}>{{ $b }}</option>
                                    @endforeach
                                </select>
                                @error('bulan_dibayar')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="tahun_dibayar" class="block text-sm font-medium text-gray-700 mb-1">Tahun Dibayar *</label>
                                <input type="number" id="tahun_dibayar" name="tahun_dibayar" value="{{ old('tahun_dibayar', $pembayaran->tahun_dibayar) }}" min="2000" max="{{ date('Y') + 1 }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('tahun_dibayar') border-red-500 @enderror" required>
                                @error('tahun_dibayar')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="jumlah_bayar" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar *</label>
                                <input type="number" id="jumlah_bayar" name="jumlah_bayar" value="{{ old('jumlah_bayar', $pembayaran->jumlah_bayar) }}" min="0" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('jumlah_bayar') border-red-500 @enderror" required>
                                @error('jumlah_bayar')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                {{ __('Simpan Perubahan') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const siswaSelect = document.getElementById('siswa_id');
            const jumlahBayarInput = document.getElementById('jumlah_bayar');

            siswaSelect.addEventListener('change', function() {
                const selectedOption = siswaSelect.options[siswaSelect.selectedIndex];
                if (selectedOption.value !== '') {
                    const sppNominal = selectedOption.getAttribute('data-spp');
                    jumlahBayarInput.value = sppNominal;
                } else {
                    jumlahBayarInput.value = '';
                }
            });
        });
    </script>
    @endpush
</x-app-layout> 