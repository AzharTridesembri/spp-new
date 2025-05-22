@extends('layouts.siswa')

@section('title', 'Riwayat Pembayaran')

@section('content')
<div class="bg-white rounded-lg shadow-md p-6">
    <h2 class="text-xl font-semibold text-indigo-700 mb-4">Riwayat Pembayaran SPP</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg overflow-hidden text-sm">
            <thead class="bg-indigo-100 text-indigo-700">
                <tr>
                    <th class="py-3 px-4 text-left">No</th>
                    <th class="py-3 px-4 text-left">Tanggal Bayar</th>
                    <th class="py-3 px-4 text-left">Bulan/Tahun</th>
                    <th class="py-3 px-4 text-left">Jumlah</th>
                    <th class="py-3 px-4 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 divide-y">
                @forelse($pembayaran as $i => $p)
                <tr class="hover:bg-indigo-50 transition">
                    <td class="py-3 px-4">{{ $i+1 }}</td>
                    <td class="py-3 px-4">{{ $p->tanggal_bayar }}</td>
                    <td class="py-3 px-4">{{ $p->bulan_dibayar }}/{{ $p->tahun_dibayar }}</td>
                    <td class="py-3 px-4">Rp {{ number_format($p->jumlah_bayar, 0, ',', '.') }}</td>
                    <td class="py-3 px-4">
                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Lunas</span>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-4 text-gray-400">Belum ada pembayaran</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection 