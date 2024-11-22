<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alats = Alat::with('alatRusaks')->get();

        return view('alats.index', compact('alats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'penyimpanan' => 'required|string|max:255',
            'letak_aset' => 'required|string|max:255',
            'foto_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('foto_path')) {
            $file = $request->file('foto_path');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('foto-alat'), $fileName);
            $filePath = 'foto-alat/' . $fileName;
        }
    
        $alat = new Alat();
        $alat->nama_barang = $request->nama_barang;
        $alat->stok = $request->stok;
        $alat->ukuran = $request->ukuran;
        $alat->penyimpanan = $request->penyimpanan;
        $alat->letak_aset = $request->letak_aset;
        $alat->foto_path = $filePath ?? null;
        $alat->save();
    
        return redirect()->route('data-alat.index')->with('success', 'Data Alat berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $alat = Alat::with(['alatMasuks', 'alatRusaks']) ->findOrFail($id);

        return view('alats.show', compact('alat'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alat $alat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat)
    {
        //
    }
}
