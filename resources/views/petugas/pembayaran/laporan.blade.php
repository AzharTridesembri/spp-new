<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Pembayaran SPP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 5px 0;
        }
        .subtitle {
            font-size: 14px;
            margin: 5px 0;
        }
        .info {
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }
        table th {
            background-color: #f2f2f2;
            text-align: left;
            font-weight: bold;
        }
        .total-row {
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            text-align: right;
        }
        .page-break {
            page-break-after: always;
        }
        .filters {
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">LAPORAN PEMBAYARAN SPP</div>
        <div class="subtitle">SMK NEGERI TEKNOLOGI</div>
        <div class="subtitle">Jl. Pendidikan No. 123, Telp. (021) 1234567</div>
    </div>
    
    <div class="info">
        <table border="0" style="width: 100%; border: none;">
            <tr>
                <td style="border: none; width: 120px;">Tanggal Cetak</td>
                <td style="border: none; width: 10px;">:</td>
                <td style="border: none;">{{ date('d F Y') }}</td>
            </tr>
            <tr>
                <td style="border: none;">Filter</td>
                <td style="border: none;">:</td>
                <td style="border: none;">
                    @if ($tanggal)
                        Tanggal: {{ date('d F Y', strtotime($tanggal)) }}
                    @endif
                    
                    @if ($bulan)
                        @if ($tanggal) | @endif
                        Bulan: {{ $bulan }}
                    @endif
                    
                    @if ($tahun)
                        @if ($tanggal || $bulan) | @endif
                        Tahun: {{ $tahun }}
                    @endif
                    
                    @if (!$tanggal && !$bulan && !$tahun)
                        Semua Data
                    @endif
                </td>
            </tr>
        </table>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Petugas</th>
                <th>Nama Siswa</th>
                <th>NISN</th>
                <th>Kelas</th>
                <th>Tanggal Bayar</th>
                <th>Bulan/Tahun</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pembayaran as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->user->name }}</td>
                    <td>{{ $item->siswa->nama }}</td>
                    <td>{{ $item->siswa->nisn }}</td>
                    <td>{{ $item->siswa->kelas->nama }}</td>
                    <td>{{ date('d/m/Y', strtotime($item->tanggal_bayar)) }}</td>
                    <td>{{ $item->bulan_dibayar }}/{{ $item->tahun_dibayar }}</td>
                    <td>Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data pembayaran</td>
                </tr>
            @endforelse
            
            @if (count($pembayaran) > 0)
                <tr class="total-row">
                    <td colspan="7" style="text-align: right;">Total Pembayaran</td>
                    <td>Rp {{ number_format($pembayaran->sum('jumlah_bayar'), 0, ',', '.') }}</td>
                </tr>
            @endif
        </tbody>
    </table>
    
    <div class="footer">
        <div style="margin-bottom: 50px;">
            {{ date('d F Y') }}<br>
            Petugas
        </div>
        <div>
            {{ auth()->user()->name }}<br>
            NIP. -
        </div>
    </div>
</body>
</html> 