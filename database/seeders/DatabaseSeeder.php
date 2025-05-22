<?php

namespace Database\Seeders;

use App\Models\Kelas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
        ]);

        // Membuat contoh data Kelas
        $kelas = [
            ['nama_kelas' => 'X RPL', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'XI RPL', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'XII RPL', 'kompetensi_keahlian' => 'Rekayasa Perangkat Lunak'],
            ['nama_kelas' => 'X TKJ', 'kompetensi_keahlian' => 'Teknik Komputer Jaringan'],
            ['nama_kelas' => 'XI TKJ', 'kompetensi_keahlian' => 'Teknik Komputer Jaringan'],
        ];

        foreach ($kelas as $k) {
            Kelas::create($k);
        }

        // Membuat contoh data SPP
        $spp = [
            ['tahun' => 2023, 'nominal' => 1500000],
            ['tahun' => 2024, 'nominal' => 1750000],
            ['tahun' => 2025, 'nominal' => 2000000],
        ];

        foreach ($spp as $s) {
            Spp::create($s);
        }

        // Membuat contoh siswa
        $siswaUser = User::where('email', 'siswa@example.com')->first();

        Siswa::create([
            'nisn' => '1234567890',
            'nis' => '12345678',
            'user_id' => $siswaUser->id,
            'nama' => 'Siswa Demo',
            'kelas_id' => 1, // X RPL
            'alamat' => 'Jl. Contoh No. 123',
            'no_telp' => '081234567890',
            'spp_id' => 2, // 2024
        ]);

        // Membuat beberapa siswa lainnya
        $siswaLain = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@example.com',
                'nisn' => '1234567891',
                'nis' => '12345679',
                'kelas_id' => 2, // XI RPL
                'alamat' => 'Jl. Merdeka No. 45',
                'no_telp' => '081234567891',
                'spp_id' => 2, // 2024
            ],
            [
                'name' => 'Siti Nuraini',
                'email' => 'siti@example.com',
                'nisn' => '1234567892',
                'nis' => '12345680',
                'kelas_id' => 3, // XII RPL
                'alamat' => 'Jl. Kenanga No. 78',
                'no_telp' => '081234567892',
                'spp_id' => 2, // 2024
            ],
            [
                'name' => 'Ahmad Jaelani',
                'email' => 'ahmad@example.com',
                'nisn' => '1234567893',
                'nis' => '12345681',
                'kelas_id' => 4, // X TKJ
                'alamat' => 'Jl. Mawar No. 12',
                'no_telp' => '081234567893',
                'spp_id' => 2, // 2024
            ],
        ];

        foreach ($siswaLain as $s) {
            $user = User::create([
                'name' => $s['name'],
                'email' => $s['email'],
                'password' => Hash::make('password'),
                'role' => 'siswa',
            ]);

            Siswa::create([
                'nisn' => $s['nisn'],
                'nis' => $s['nis'],
                'user_id' => $user->id,
                'nama' => $s['name'],
                'kelas_id' => $s['kelas_id'],
                'alamat' => $s['alamat'],
                'no_telp' => $s['no_telp'],
                'spp_id' => $s['spp_id'],
            ]);
        }

        // Membuat contoh data pembayaran
        $adminUser = User::where('role', 'admin')->first();
        $petugasUser = User::where('role', 'petugas')->first();
        $siswa = Siswa::all();
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Pembayaran untuk Siswa Demo (3 bulan)
        $siswaDemo = Siswa::where('nisn', '1234567890')->first();
        $nominalSpp = $siswaDemo->spp->nominal / 12; // Nominal per bulan

        for ($i = 0; $i < 3; $i++) {
            Pembayaran::create([
                'user_id' => $adminUser->id,
                'siswa_id' => $siswaDemo->id,
                'tanggal_bayar' => Carbon::now()->subMonths(2 - $i)->format('Y-m-d'),
                'bulan_dibayar' => $bulan[$i],
                'tahun_dibayar' => 2024,
                'jumlah_bayar' => $nominalSpp,
            ]);
        }

        // Pembayaran untuk siswa lain (random 1-6 bulan)
        foreach ($siswa->skip(1) as $s) {
            $jumlahBulan = rand(1, 6);
            $nominalSpp = $s->spp->nominal / 12;

            for ($i = 0; $i < $jumlahBulan; $i++) {
                Pembayaran::create([
                    'user_id' => ($i % 2 == 0) ? $adminUser->id : $petugasUser->id, // Bergantian admin dan petugas
                    'siswa_id' => $s->id,
                    'tanggal_bayar' => Carbon::now()->subMonths(5 - $i)->format('Y-m-d'),
                    'bulan_dibayar' => $bulan[$i],
                    'tahun_dibayar' => 2024,
                    'jumlah_bayar' => $nominalSpp,
                ]);
            }
        }
    }
}
