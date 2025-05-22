@extends('layouts.petugas')

@section('title', 'Pembayaran SPP')

@section('content')
<div class="bg-white rounded-lg shadow-md">
    <div class="p-6 flex flex-col md:flex-row md:justify-between md:items-center border-b gap-4">
        <h2 class="text-xl font-semibold text-gray-800">Pembayaran SPP</h2>
        <div class="flex space-x-2">
            <a href="{{ route('petugas.pembayaran.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition flex items-center gap-2">
                <i class="fas fa-plus"></i> <span class="hidden sm:inline">Tambah Pembayaran</span>
            </a>
            <a href="{{ route('petugas.laporan') }}" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition flex items-center gap-2">
                <i class="fas fa-file-alt"></i> <span class="hidden sm:inline">Generate Laporan</span>
            </a>
        </div>
    </div>
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif
    <div class="overflow-x-auto p-0 md:p-6">
        <table class="min-w-full bg-white rounded-lg overflow-hidden text-sm">
            <thead class="bg-gray-100 text-gray-700 sticky top-0 z-10">
                <tr>
                    <th class="py-3 px-4 text-left whitespace-nowrap">No</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Petugas</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Siswa</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap hidden md:table-cell">NISN</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap hidden lg:table-cell">Kelas</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Tanggal</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Bulan/Tahun</th>
                    <th class="py-3 px-4 text-left whitespace-nowrap">Jumlah</th>
                    <th class="py-3 px-4 text-center whitespace-nowrap">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($pembayaran as $index => $item)
                    <tr class="hover:bg-blue-50 transition">
                        <td class="py-3 px-4">{{ $index + $pembayaran->firstItem() }}</td>
                        <td class="py-3 px-4">{{ $item->user->name ?? '-' }}</td>
                        <td class="py-3 px-4 font-semibold text-blue-700">{{ $item->siswa->nama }}</td>
                        <td class="py-3 px-4 hidden md:table-cell">{{ $item->siswa->nisn }}</td>
                        <td class="py-3 px-4 hidden lg:table-cell">{{ $item->siswa->kelas->nama_kelas }}</td>
                        <td class="py-3 px-4">{{ date('d/m/Y', strtotime($item->tanggal_bayar)) }}</td>
                        <td class="py-3 px-4">
                            <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">{{ $item->bulan_dibayar }}/{{ $item->tahun_dibayar }}</span>
                        </td>
                        <td class="py-3 px-4 font-bold text-green-600">Rp {{ number_format($item->jumlah_bayar, 0, ',', '.') }}</td>
                        <td class="py-3 px-4 flex items-center justify-center space-x-2">
                            <a href="{{ route('petugas.pembayaran.show', $item->id) }}" class="p-2 bg-blue-100 text-blue-600 rounded hover:bg-blue-200" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('petugas.pembayaran.edit', $item->id) }}" class="p-2 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('petugas.pembayaran.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-2 bg-red-100 text-red-600 rounded hover:bg-red-200" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="py-6 px-4 text-center text-gray-500">Tidak ada data pembayaran</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4 px-4">
            {{ $pembayaran->links() }}
        </div>
    </div>
</div>
@endsection 