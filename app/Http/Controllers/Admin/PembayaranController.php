<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Spp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pembayarans = Pembayaran::with(['user', 'siswa.kelas', 'siswa.spp'])->latest()->paginate(10);
        return view('admin.pembayaran.index', compact('pembayarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siswa = Siswa::with(['kelas', 'spp'])->get();
        $bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        return view('admin.pembayaran.create', compact('siswa', 'bulan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_bayar' => 'required|date',
            'bulan_dibayar' => 'required|array|min:1',
            'bulan_dibayar.*' => 'required|string',
            'tahun_dibayar' => 'required|integer',
        ]);

        $siswa = Siswa::findOrFail($request->siswa_id);
        $spp = Spp::findOrFail($siswa->spp_id);

        $jumlah_bulan = count($request->bulan_dibayar);
        $jumlah_bayar = $spp->nominal * $jumlah_bulan;

        // Cek pembayaran ganda
        $existing = Pembayaran::where('siswa_id', $request->siswa_id)
            ->whereIn('bulan_dibayar', $request->bulan_dibayar)
            ->where('tahun_dibayar', $request->tahun_dibayar)
            ->pluck('bulan_dibayar')
            ->toArray();

        if (!empty($existing)) {
            return back()->with('error', 'Pembayaran untuk bulan: ' . implode(', ', $existing) . ' sudah ada.');
        }

        try {
            DB::beginTransaction();
            foreach ($request->bulan_dibayar as $bulan) {
                Pembayaran::create([
                    'user_id' => 1,
                    'siswa_id' => $request->siswa_id,
                    'tanggal_bayar' => $request->tanggal_bayar,
                    'bulan_dibayar' => $bulan,
                    'tahun_dibayar' => $request->tahun_dibayar,
                    'jumlah_bayar' => $spp->nominal,
                ]);
            }
            DB::commit();
            return redirect()->route('admin.pembayaran.index')->with('success', 'Pembayaran berhasil.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        return view('admin.pembayaran.show', compact('pembayaran'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        $siswas = Siswa::all();
        $spps = Spp::all();
        return view('admin.pembayaran.edit', compact('pembayaran', 'siswas', 'spps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'tanggal_bayar' => 'required|date',
            'bulan_dibayar' => 'required|string',
            'tahun_dibayar' => 'required|integer',
            'jumlah_bayar' => 'required|numeric',
        ]);

        // Cek apakah sudah ada pembayaran untuk bulan dan tahun yang sama
        $existingPayment = Pembayaran::where('siswa_id', $request->siswa_id)
            ->where('bulan_dibayar', $request->bulan_dibayar)
            ->where('tahun_dibayar', $request->tahun_dibayar)
            ->where('id', '!=', $pembayaran->id)
            ->first();

        if ($existingPayment) {
            return back()->with('error', 'Pembayaran untuk bulan dan tahun ini sudah ada.');
        }

        // Dapatkan SPP untuk siswa ini
        $siswa = Siswa::findOrFail($request->siswa_id);
        $spp = Spp::findOrFail($siswa->spp_id);

        // Validasi jumlah pembayaran
        if ($request->jumlah_bayar < $spp->nominal) {
            return back()->with('error', 'Jumlah pembayaran kurang dari nominal SPP.');
        }

        try {
            DB::beginTransaction();

            $pembayaran->update([
                'siswa_id' => $request->siswa_id,
                'tanggal_bayar' => $request->tanggal_bayar,
                'bulan_dibayar' => $request->bulan_dibayar,
                'tahun_dibayar' => $request->tahun_dibayar,
                'jumlah_bayar' => $request->jumlah_bayar,
            ]);

            DB::commit();

            return redirect()->route('admin.pembayaran.index')
                ->with('success', 'Pembayaran berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        try {
            DB::beginTransaction();
            $pembayaran->delete();
            DB::commit();

            return redirect()->route('admin.pembayaran.index')
                ->with('success', 'Pembayaran berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
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

        $bulanList = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $tahunList = range(date('Y') - 5, date('Y'));

        if ($request->has('export_pdf')) {
            $pdf = PDF::loadView('admin.pembayaran.laporan', compact('pembayaran', 'tanggal', 'bulan', 'tahun'));
            return $pdf->download('laporan-pembayaran-' . time() . '.pdf');
        }

        return view('admin.pembayaran.laporan-form', compact('pembayaran', 'bulanList', 'tahunList', 'tanggal', 'bulan', 'tahun'));
    }

    /**
     * AJAX: Mengembalikan array bulan yang sudah dibayar oleh siswa di tahun tertentu
     */
    public function bulanSudahDibayar(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:siswas,id',
            'bulan' => 'required|string',
            'tahun' => 'required|integer',
        ]);

        $pembayaran = Pembayaran::where('siswa_id', $request->siswa_id)
            ->where('bulan_dibayar', $request->bulan)
            ->where('tahun_dibayar', $request->tahun)
            ->first();

        return response()->json([
            'sudah_dibayar' => $pembayaran !== null
        ]);
    }
}
