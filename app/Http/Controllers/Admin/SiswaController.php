<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Spp;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'spp', 'user'])->orderBy('nama');

        if ($request->has('search')) {
            $searchTerm = $request->search;
            $query->where('nama', 'like', '%' . $searchTerm . '%')
                ->orWhere('nisn', 'like', '%' . $searchTerm . '%')
                ->orWhere('nis', 'like', '%' . $searchTerm . '%');
        }

        $siswas = $query->paginate(10);

        return view('admin.siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $spps = Spp::orderBy('tahun', 'desc')->get();

        return view('admin.siswa.create', compact('kelas', 'spps'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nisn' => 'required|string|size:10|unique:siswas',
            'nis' => 'required|string|size:8|unique:siswas',
            'nama' => 'required|string|max:35',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:13',
            'spp_id' => 'required|exists:spps,id',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.siswa.create')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Buat user terlebih dahulu
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => User::ROLE_SISWA,
            ]);

            // Kemudian buat siswa
            Siswa::create([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'user_id' => $user->id,
                'nama' => $request->nama,
                'kelas_id' => $request->kelas_id,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'spp_id' => $request->spp_id,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.siswa.index')
                ->with('success', 'Siswa berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.siswa.create')
                ->with('error', 'Gagal menambahkan siswa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $kelas = \App\Models\Kelas::all();
        $spps = \App\Models\Spp::all();
        return view('admin.siswa.edit', compact('siswa', 'kelas', 'spps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $request->validate([
            'nisn' => 'required|string|unique:siswas,nisn,' . $siswa->id,
            'nis' => 'required|string|unique:siswas,nis,' . $siswa->id,
            'nama' => 'required|string|max:255',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:15',
            'spp_id' => 'required|exists:spps,id',
        ]);

        $siswa->update($request->all());

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        $siswa->delete();

        return redirect()->route('admin.siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    /**
     * Display payment history for a specific student.
     */
    public function paymentHistory(Siswa $siswa)
    {
        // Ambil semua pembayaran untuk siswa ini
        $payments = $siswa->pembayaran()->orderBy('tahun_dibayar', 'asc')->orderBy('bulan_dibayar', 'asc')->get();

        // Daftar semua bulan dalam setahun
        $allMonths = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        // Kelompokkan pembayaran per tahun
        $paymentsByYear = $payments->groupBy('tahun_dibayar');

        // Siapkan data riwayat pembayaran per tahun
        $history = [];
        foreach ($paymentsByYear as $year => $paymentsInYear) {
            $paidMonths = $paymentsInYear->pluck('bulan_dibayar')->toArray();
            $unpaidMonths = array_diff($allMonths, $paidMonths);

            // Urutkan bulan yang belum dibayar sesuai urutan kalender
            usort($unpaidMonths, function ($a, $b) use ($allMonths) {
                return array_search($a, $allMonths) - array_search($b, $allMonths);
            });

            // Urutkan bulan yang sudah dibayar sesuai urutan kalender
            usort($paidMonths, function ($a, $b) use ($allMonths) {
                return array_search($a, $allMonths) - array_search($b, $allMonths);
            });


            $history[$year] = [
                'paid' => $paidMonths,
                'unpaid' => $unpaidMonths,
            ];
        }

        // Jika siswa belum punya pembayaran, tampilkan semua bulan sebagai belum dibayar untuk tahun sekarang
        if ($payments->isEmpty()) {
            $currentYear = date('Y');
            $history[$currentYear] = [
                'paid' => [],
                'unpaid' => $allMonths
            ];
        }

        // Sort history by year
        krsort($history);

        return view('admin.siswa.payment_history', compact('siswa', 'history'));
    }
}
