<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Laporan' }}</title>
    
    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')
    
    <style>
        @media print {
            /* Reset margin dan padding */
            body {
                margin: 0;
                padding: 0;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            
            /* Sembunyikan elemen yang tidak perlu di-print */
            .no-print {
                display: none !important;
            }
            
            /* Pastikan tabel tidak terpotong */
            table {
                page-break-inside: auto;
            }
            
            tr {
                page-break-inside: avoid;
                page-break-after: auto;
            }
            
            thead {
                display: table-header-group;
            }
            
            tfoot {
                display: table-footer-group;
            }
            
            /* Ukuran kertas A4 */
            @page {
                size: A4;
                margin: 2cm;
            }
            
            /* Header dan footer tetap muncul di setiap halaman */
            .page-header {
                position: running(header);
            }
            
            .page-footer {
                position: running(footer);
            }
            
            @page {
                @top-center {
                    content: element(header);
                }
                @bottom-center {
                    content: element(footer);
                }
            }
            
            /* Nomor halaman */
            .page-number:after {
                content: counter(page);
            }
            
            .page-number {
                counter-increment: page;
            }
        }
    </style>
</head>
<body class="bg-white">
    <!-- Tombol print dan navigasi (hanya muncul di browser) -->
    <div class="no-print fixed top-4 right-4 z-50">
        <div class="flex gap-2">
            <button onclick="window.print()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                Print Laporan
            </button>
            <a href="{{ url()->previous() }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow">
                Kembali
            </a>
        </div>
    </div>

    <!-- Header Laporan -->
    <div class="page-header">
        <div class="text-center py-4 border-b">
            <h1 class="text-2xl font-bold">{{ $title ?? 'Laporan' }}</h1>
            <p class="text-gray-600">{{ $subtitle ?? '' }}</p>
            <p class="text-sm text-gray-500">Tanggal: {{ $date ?? now()->format('d F Y') }}</p>
        </div>
    </div>

    <!-- Konten Laporan -->
    <div class="p-4">
        <!-- Informasi Filter -->
        @if(isset($filter))
        <div class="mb-4 text-sm text-gray-700">
            <p class="font-semibold mb-1">Detail Filter:</p>
            <ul class="list-disc list-inside pl-4">
                @if(!empty($filter['tanggal']))
                    <li>Tanggal: {{ date('d/m/Y', strtotime($filter['tanggal'])) }}</li>
                @endif
                @if(!empty($filter['bulan']))
                    <li>Bulan: {{ $filter['bulan'] }}</li>
                @endif
                @if(!empty($filter['tahun']))
                    <li>Tahun: {{ $filter['tahun'] }}</li>
                @endif
                 @if(!empty($filter['start_date']))
                    <li>Tanggal Mulai: {{ date('d/m/Y', strtotime($filter['start_date'])) }}</li>
                @endif
                @if(!empty($filter['end_date']))
                    <li>Tanggal Akhir: {{ date('d/m/Y', strtotime($filter['end_date'])) }}</li>
                @endif
                 @if(!empty($filter['kelas_id']))
                    <li>Kelas: {{ $pembayaran->first()->siswa->kelas->nama_kelas ?? '-' }}</li>
                @endif
                @if(!empty($filter['siswa_id']))
                    <li>Siswa: {{ $pembayaran->first()->siswa->nama ?? '-' }}</li>
                @endif
            </ul>
        </div>
        @endif

        <!-- Tabel Pembayaran -->
        <div class="mb-4">
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border p-2 text-left">No</th>
                        <th class="border p-2 text-left">Tanggal Bayar</th>
                        <th class="border p-2 text-left">NISN</th>
                        <th class="border p-2 text-left">Nama Siswa</th>
                        <th class="border p-2 text-left">Kelas</th>
                        <th class="border p-2 text-left">Bulan Dibayar</th>
                        <th class="border p-2 text-left">Tahun Dibayar</th>
                        <th class="border p-2 text-right">Jumlah Bayar</th>
                        <th class="border p-2 text-left">Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran ?? [] as $index => $item)
                    <tr>
                        <td class="border p-2">{{ $index + 1 }}</td>
                        <td class="border p-2">{{ date('d/m/Y', strtotime($item->tanggal_bayar)) }}</td>
                        <td class="border p-2">{{ $item->siswa->nisn }}</td>
                        <td class="border p-2">{{ $item->siswa->nama }}</td>
                        <td class="border p-2">{{ $item->siswa->kelas->nama_kelas }}</td>
                        <td class="border p-2">{{ $item->bulan_dibayar }}</td>
                        <td class="border p-2">{{ $item->tahun_dibayar }}</td>
                        <td class="border p-2 text-right">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="border p-2">{{ $item->user->name }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="border p-2 text-center">Tidak ada data pembayaran</td>
                    </tr>
                    @endforelse
                </tbody>
                @if(isset($total))
                <tfoot>
                    <tr class="bg-gray-50 font-bold">
                        <td colspan="7" class="border p-2 text-right">Total:</td>
                        <td class="border p-2 text-right">Rp {{ number_format($total, 0, ',', '.') }}</td>
                        <td class="border p-2"></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>
    </div>

    <!-- Footer Laporan -->
    <div class="page-footer">
        <div class="text-center py-4 border-t text-sm text-gray-600">
            <p>Halaman <span class="page-number"></span></p>
            <p>{{ $footer ?? 'Dicetak pada: ' . now()->format('d/m/Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html> 