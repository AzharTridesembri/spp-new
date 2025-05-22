<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Spp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SppController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $spps = Spp::orderBy('tahun', 'desc')->paginate(10);
        return view('admin.spp.index', compact('spps'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.spp.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tahun' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 5),
            'nominal' => 'required|numeric|min:1000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.spp.create')
                ->withErrors($validator)
                ->withInput();
        }

        Spp::create($request->all());

        return redirect()
            ->route('admin.spp.index')
            ->with('success', 'Data SPP berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $spp = Spp::with('siswa')->findOrFail($id);
        return view('admin.spp.show', compact('spp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $spp = Spp::findOrFail($id);
        return view('admin.spp.edit', compact('spp'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $spp = Spp::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tahun' => 'required|digits:4|integer|min:1900|max:' . (date('Y') + 5),
            'nominal' => 'required|numeric|min:1000',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.spp.edit', $spp->id)
                ->withErrors($validator)
                ->withInput();
        }

        $spp->update($request->all());

        return redirect()
            ->route('admin.spp.index')
            ->with('success', 'Data SPP berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $spp = Spp::findOrFail($id);
            $spp->delete();

            return redirect()
                ->route('admin.spp.index')
                ->with('success', 'Data SPP berhasil dihapus.');

        } catch (\Exception $e) {
            return redirect()
                ->route('admin.spp.index')
                ->with('error', 'Data SPP tidak dapat dihapus karena masih digunakan.');
        }
    }
}
