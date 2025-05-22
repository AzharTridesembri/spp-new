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
                <tr class="hover:bg-indigo-50 transition">
                    <td class="py-3 px-4">1</td>
                    <td class="py-3 px-4">2024-05-01</td>
                    <td class="py-3 px-4">Mei/2024</td>
                    <td class="py-3 px-4">Rp 150.000</td>
                    <td class="py-3 px-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Lunas</span></td>
                </tr>
                <tr class="hover:bg-indigo-50 transition">
                    <td class="py-3 px-4">2</td>
                    <td class="py-3 px-4">2024-04-01</td>
                    <td class="py-3 px-4">April/2024</td>
                    <td class="py-3 px-4">Rp 150.000</td>
                    <td class="py-3 px-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Lunas</span></td>
                </tr>
                <tr class="hover:bg-indigo-50 transition">
                    <td class="py-3 px-4">3</td>
                    <td class="py-3 px-4">2024-03-01</td>
                    <td class="py-3 px-4">Maret/2024</td>
                    <td class="py-3 px-4">Rp 150.000</td>
                    <td class="py-3 px-4"><span class="px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">Lunas</span></td>
                </tr>
                <tr class="hover:bg-indigo-50 transition">
                    <td class="py-3 px-4">4</td>
                    <td class="py-3 px-4">-</td>
                    <td class="py-3 px-4">Februari/2024</td>
                    <td class="py-3 px-4">Rp 150.000</td>
                    <td class="py-3 px-4"><span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded text-xs font-semibold">Belum Lunas</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection 