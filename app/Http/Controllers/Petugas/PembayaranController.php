<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Spp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayaran = Pembayaran::with(['user', 'siswa.kelas', 'siswa.spp'])->latest()->paginate(10);
        return view('petugas.pembayaran.index', compact('pembayaran'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::with('spp')->get();
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('petugas.pembayaran.create', compact('siswa', 'bulan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_bayar' => 'required|date',
            'bulan_dibayar' => 'required|array|min:1',
            'bulan_dibayar.*' => 'required|in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember',
            'tahun_dibayar' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil data SPP siswa
        $siswa = Siswa::with('spp')->findOrFail($request->siswa_id);
        $nominalSpp = $siswa->spp->nominal;

        // Cek pembayaran yang sudah ada
        $existingPayments = Pembayaran::where('siswa_id', $request->siswa_id)
            ->whereIn('bulan_dibayar', $request->bulan_dibayar)
            ->where('tahun_dibayar', $request->tahun_dibayar)
            ->pluck('bulan_dibayar')
            ->toArray();

        if (!empty($existingPayments)) {
            return redirect()->back()
                ->with('error', 'Pembayaran untuk bulan ' . implode(', ', $existingPayments) . ' sudah dilakukan')
                ->withInput();
        }

        // Simpan pembayaran per bulan
        foreach ($request->bulan_dibayar as $bulan) {
            Pembayaran::create([
                'user_id' => auth()->id(),
                'siswa_id' => $request->siswa_id,
                'tanggal_bayar' => $request->tanggal_bayar,
                'bulan_dibayar' => $bulan,
                'tahun_dibayar' => $request->tahun_dibayar,
                'jumlah_bayar' => $nominalSpp,
            ]);
        }

        return redirect()->route('petugas.pembayaran.index')->with('success', 'Pembayaran berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pembayaran = Pembayaran::with(['user', 'siswa.kelas', 'siswa.spp'])->findOrFail($id);
        return view('petugas.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $siswa = Siswa::with('spp')->get();
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('petugas.pembayaran.edit', compact('pembayaran', 'siswa', 'bulan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator = Validator::make($request->all(), [
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_bayar' => 'required|date',
            'bulan_dibayar' => 'required|in:Januari,Februari,Maret,April,Mei,Juni,Juli,Agustus,September,Oktober,November,Desember',
            'tahun_dibayar' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
            'jumlah_bayar' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->update([
            'user_id' => 1,
            'siswa_id' => $request->siswa_id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'bulan_dibayar' => $request->bulan_dibayar,
            'tahun_dibayar' => $request->tahun_dibayar,
            'jumlah_bayar' => $request->jumlah_bayar,
        ]);

        return redirect()->route('petugas.pembayaran.index')->with('success', 'Pembayaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->delete();

        return redirect()->route('petugas.pembayaran.index')->with('success', 'Pembayaran berhasil dihapus');
    }

    /**
     * Generate PDF report of payments
     */
    public function generateReport(Request $request)
    {
        $tanggal = $request->tanggal ?? null;
        $bulan = $request->bulan ?? null;
        $tahun = $request->tahun ?? null;

        $query = Pembayaran::with(['user', 'siswa.kelas', 'siswa.spp']);

        if ($tanggal) {
            $query->whereDate('tanggal_bayar', $tanggal);
        }

        if ($bulan) {
            $query->where('bulan_dibayar', $bulan);
        }

        if ($tahun) {
            $query->where('tahun_dibayar', $tahun);
        }

        $pembayaran = $query->latest()->get();

        if ($request->has('download')) {
            $pdf = PDF::loadView('petugas.pembayaran.laporan', compact('pembayaran', 'tanggal', 'bulan', 'tahun'));
            return $pdf->download('laporan-pembayaran-' . time() . '.pdf');
        } elseif ($request->has('preview')) {
            $pdf = PDF::loadView('petugas.pembayaran.laporan', compact('pembayaran', 'tanggal', 'bulan', 'tahun'));
            return $pdf->stream('laporan-pembayaran-' . time() . '.pdf');
        }

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahunList = range(date('Y') - 5, date('Y'));

        return view('petugas.pembayaran.laporan-form', compact('pembayaran', 'bulanList', 'tahunList', 'tanggal', 'bulan', 'tahun'));
    }

    /**
     * AJAX: Mengembalikan array bulan yang sudah dibayar oleh siswa di tahun tertentu
     */
    public function bulanSudahDibayar(Request $request)
    {
        $siswa_id = $request->siswa_id;
        $tahun = $request->tahun;

        $sudahDibayar = [];
        if ($siswa_id && $tahun) {
            $sudahDibayar = Pembayaran::where('siswa_id', $siswa_id)
                ->where('tahun_dibayar', $tahun)
                ->pluck('bulan_dibayar')
                ->toArray();
        }

        return response()->json($sudahDibayar);
    }
}
