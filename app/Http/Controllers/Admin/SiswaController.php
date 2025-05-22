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
    public function index()
    {
        $siswas = Siswa::with(['kelas', 'spp', 'user'])->orderBy('nama')->paginate(10);
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
    public function show(string $id)
    {
        $siswa = Siswa::with(['kelas', 'spp', 'user', 'pembayaran'])->findOrFail($id);
        return view('admin.siswa.show', compact('siswa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);
        $kelas = Kelas::orderBy('nama_kelas')->get();
        $spps = Spp::orderBy('tahun', 'desc')->get();

        return view('admin.siswa.edit', compact('siswa', 'kelas', 'spps'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nisn' => ['required', 'string', 'size:10', Rule::unique('siswas')->ignore($siswa->id)],
            'nis' => ['required', 'string', 'size:8', Rule::unique('siswas')->ignore($siswa->id)],
            'nama' => 'required|string|max:35',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($siswa->user_id)],
            'password' => 'nullable|string|min:8',
            'kelas_id' => 'required|exists:kelas,id',
            'alamat' => 'required|string',
            'no_telp' => 'required|string|max:13',
            'spp_id' => 'required|exists:spps,id',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.siswa.edit', $siswa->id)
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

        try {
            // Update user
            $userData = [
                'name' => $request->nama,
                'email' => $request->email,
            ];

            // Update password hanya jika ada input baru
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }

            $siswa->user->update($userData);

            // Update siswa
            $siswa->update([
                'nisn' => $request->nisn,
                'nis' => $request->nis,
                'nama' => $request->nama,
                'kelas_id' => $request->kelas_id,
                'alamat' => $request->alamat,
                'no_telp' => $request->no_telp,
                'spp_id' => $request->spp_id,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.siswa.index')
                ->with('success', 'Data siswa berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.siswa.edit', $siswa->id)
                ->with('error', 'Gagal memperbarui data siswa: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $siswa = Siswa::with('user')->findOrFail($id);

        try {
            DB::beginTransaction();

            // Hapus siswa
            $siswa->delete();

            // Hapus user terkait
            if ($siswa->user) {
                $siswa->user->delete();
            }

            DB::commit();

            return redirect()
                ->route('admin.siswa.index')
                ->with('success', 'Siswa berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->route('admin.siswa.index')
                ->with('error', 'Siswa tidak dapat dihapus karena masih memiliki data pembayaran.');
        }
    }
}
