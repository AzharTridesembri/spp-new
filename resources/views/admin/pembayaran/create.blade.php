<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Pembayaran SPP') }}
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

                    <form action="{{ route('admin.pembayaran.store') }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="siswa_id" class="block text-sm font-medium text-gray-700 mb-1">Siswa *</label>
                                <select id="siswa_id" name="siswa_id" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('siswa_id') border-red-500 @enderror" required>
                                    <option value="">Pilih Siswa</option>
                                    @foreach($siswa as $s)
                                        <option value="{{ $s->id }}" data-spp="{{ $s->spp->nominal }}" {{ old('siswa_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama }} - {{ $s->nisn }} - {{ $s->kelas->nama_kelas }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('siswa_id')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="tanggal_bayar" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Bayar *</label>
                                <input type="date" id="tanggal_bayar" name="tanggal_bayar" value="{{ old('tanggal_bayar', date('Y-m-d')) }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('tanggal_bayar') border-red-500 @enderror" required>
                                @error('tanggal_bayar')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Bulan Dibayar *</label>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($bulan as $index => $namaBulan)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="bulan_dibayar[]" value="{{ $namaBulan }}" id="bulan_{{ $index }}" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            <label for="bulan_{{ $index }}" class="ml-2 text-sm text-gray-700">{{ $namaBulan }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @error('bulan_dibayar')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="tahun_dibayar" class="block text-sm font-medium text-gray-700 mb-1">Tahun Dibayar *</label>
                                <input type="number" id="tahun_dibayar" name="tahun_dibayar" value="{{ old('tahun_dibayar', date('Y')) }}" min="2000" max="{{ date('Y') + 1 }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('tahun_dibayar') border-red-500 @enderror" required>
                                @error('tahun_dibayar')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>

                            <div>
                                <label for="jumlah_bayar" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Bayar *</label>
                                <input type="text" name="jumlah_bayar" id="jumlah_bayar" value="{{ old('jumlah_bayar') }}" class="w-full rounded-md shadow-sm border-gray-300 focus:border-green-500 focus:ring-green-500 text-green-600 font-bold" autocomplete="off">
                                @error('jumlah_bayar')
                                    <span class="text-red-500 text-xs">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                                {{ __('Simpan') }}
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
            const tahunInput = document.getElementById('tahun_dibayar');
            const bulanCheckboxes = document.querySelectorAll('input[name=\"bulan_dibayar[]\"]');
            const jumlahBayarInput = document.getElementById('jumlah_bayar');

            function formatRupiah(angka) {
                angka = angka.replace(/[^0-9]/g, '');
                if (!angka) return '';
                return 'Rp ' + parseInt(angka, 10).toLocaleString('id-ID');
            }

            function updateJumlahBayar() {
                console.log('updateJumlahBayar dipanggil');
                const selectedOption = siswaSelect.options[siswaSelect.selectedIndex];
                console.log('Selected option:', selectedOption);
                if (selectedOption.value !== '') {
                    const sppNominal = parseInt(selectedOption.getAttribute('data-spp')) || 0;
                    console.log('SPP Nominal:', sppNominal);
                    const selectedMonths = document.querySelectorAll('input[name=\"bulan_dibayar[]\"]:checked:not(:disabled)').length;
                    console.log('Selected months:', selectedMonths);
                    const totalBayar = sppNominal * selectedMonths;
                    console.log('Total bayar:', totalBayar);
                    jumlahBayarInput.value = totalBayar ? formatRupiah(totalBayar.toString()) : '';
                    console.log('Jumlah bayar input value:', jumlahBayarInput.value);
                } else {
                    jumlahBayarInput.value = '';
                }
            }

            function updateBulanCheckboxes() {
                console.log('updateBulanCheckboxes dipanggil');
                const siswaId = siswaSelect.value;
                const tahun = tahunInput.value;
                console.log('Siswa ID:', siswaId, 'Tahun:', tahun);
                if (!siswaId || !tahun) return;

                fetch(`/api/pembayaran/bulan-sudah-dibayar?siswa_id=${siswaId}&tahun=${tahun}`)
                    .then(response => response.json())
                    .then(sudahDibayar => {
                        console.log('Bulan sudah dibayar:', sudahDibayar);
                        bulanCheckboxes.forEach(cb => {
                            const label = cb.parentElement.querySelector('label');
                            if (sudahDibayar.includes(cb.value)) {
                                cb.checked = true;
                                cb.disabled = true;
                                label.innerHTML = cb.value + ' <span style=\"color:green;font-size:11px;\">(Sudah dibayar)</span>';
                            } else {
                                cb.checked = false;
                                cb.disabled = false;
                                label.innerHTML = cb.value;
                            }
                        });
                        updateJumlahBayar();
                    })
                    .catch(error => {
                        console.error('Error fetching bulan sudah dibayar:', error);
                    });
            }

            siswaSelect.addEventListener('change', function() {
                updateBulanCheckboxes();
            });
            tahunInput.addEventListener('change', function() {
                updateBulanCheckboxes();
            });
            bulanCheckboxes.forEach(cb => {
                cb.addEventListener('change', updateJumlahBayar);
            });

            // Format input saat user mengetik
            jumlahBayarInput.addEventListener('input', function(e) {
                jumlahBayarInput.value = formatRupiah(jumlahBayarInput.value);
            });

            // Saat submit, hanya angka yang dikirim
            jumlahBayarInput.form && jumlahBayarInput.form.addEventListener('submit', function() {
                jumlahBayarInput.value = jumlahBayarInput.value.replace(/[^0-9]/g, '');
            });

            // Inisialisasi saat halaman pertama kali dibuka
            updateBulanCheckboxes();
        });
    </script>
    @endpush
</x-app-layout> 
