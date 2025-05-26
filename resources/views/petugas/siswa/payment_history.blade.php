@extends('layouts.petugas')

@section('title', __('Riwayat Pembayaran SPP Siswa: ' . $siswa->nama))

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">

                {{-- Detail Siswa --}}
                <div class="mb-6 p-4 border rounded-md bg-emerald-50">
                    <h3 class="font-semibold text-lg mb-3 text-emerald-800">Detail Siswa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div><p class="text-sm font-medium text-gray-600">NISN:</p><p class="text-gray-900">{{ $siswa->nisn }}</p></div>
                        <div><p class="text-sm font-medium text-gray-600">NIS:</p><p class="text-gray-900">{{ $siswa->nis }}</p></div>
                        <div><p class="text-sm font-medium text-gray-600">Nama:</p><p class="text-gray-900">{{ $siswa->nama }}</p></div>
                        <div><p class="text-sm font-medium text-gray-600">Kelas:</p><p class="text-gray-900">{{ $siswa->kelas->nama_kelas }}</p></div>
                        <div><p class="text-sm font-medium text-gray-600">SPP Nominal:</p><p class="text-gray-900">Rp {{ number_format($siswa->spp->nominal ?? 0, 0, ',', '.') }}</p></div>
                    </div>
                </div>

                {{-- Payment History By Year Card --}}
                <div class="mt-6">
                     <h3 class="font-semibold text-lg mb-4 text-gray-700">Riwayat Pembayaran per Tahun</h3>

                     @forelse ($history as $year => $data)
                         <div class="mb-6 p-4 border rounded-md bg-gray-50">
                             <h4 class="font-semibold text-md mb-3 text-gray-800">Tahun: {{ $year }}</h4>

                             {{-- Bulan Sudah Dibayar --}}
                             <div class="mb-4">
                                 <p class="font-semibold mb-2 text-green-700">Bulan Sudah Dibayar ({{ count($data['paid']) }}):</p>
                                 @if(count($data['paid']) > 0)
                                     <div class="flex flex-wrap gap-2">
                                         @foreach($data['paid'] as $month)
                                             <span class="bg-green-200 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $month }}</span>
                                         @endforeach
                                     </div>
                                 @else
                                     <p class="text-gray-600 text-sm">Belum ada pembayaran untuk tahun ini.</p>
                                 @endif
                             </div>

                             {{-- Bulan Belum Dibayar --}}
                             <div>
                                  <p class="font-semibold mb-2 text-red-700">Bulan Belum Dibayar ({{ count($data['unpaid']) }}):</p>
                                  @if(count($data['unpaid']) > 0)
                                      <div class="flex flex-wrap gap-2">
                                          @foreach($data['unpaid'] as $month)
                                              <span class="bg-red-200 text-red-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">{{ $month }}</span>
                                          @endforeach
                                      </div>
                                  @else
                                      <p class="text-gray-600 text-sm">Semua bulan sudah dibayar untuk tahun ini.</p>
                                  @endif
                               </div>
                           </div>
                       @empty
                           <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-md">
                               Belum ada riwayat pembayaran per tahun untuk siswa ini.
                           </div>
                       @endforelse

                   </div>

              </div>
          </div>
      </div>
  </div>
@endsection 