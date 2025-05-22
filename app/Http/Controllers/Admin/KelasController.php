<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();
        return view('admin.kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kelas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:10|unique:kelas',
            'kompetensi_keahlian' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.kelas.create')
                ->withErrors($validator)
                ->withInput();
        }

        Kelas::create($request->all());

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $kelas = Kelas::with('siswa')->findOrFail($id);
        return view('admin.kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        return view('admin.kelas.edit', compact('kelas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $kelas = Kelas::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nama_kelas' => 'required|string|max:10|unique:kelas,nama_kelas,' . $id,
            'kompetensi_keahlian' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.kelas.edit', $kelas->id)
                ->withErrors($validator)
                ->withInput();
        }

        $kelas->update($request->all());

        return redirect()
            ->route('admin.kelas.index')
            ->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $kelas = Kelas::findOrFail($id);
            $kelas->delete();

            return redirect()
                ->route('admin.kelas.index')
                ->with('success', 'Kelas berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.kelas.index')
                ->with('error', 'Kelas tidak dapat dihapus karena masih digunakan.');
        }
    }
}
