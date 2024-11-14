<?php

namespace App\Http\Controllers;

use App\Models\BentukSediaan;
use App\Models\Kemasan;
use App\Models\Obat;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obats = Obat::with('stokKeluars')->get();
        $kemasans = Kemasan::all();
        $satuans = Satuan::all();
        $bentukSediaans = BentukSediaan::all();

        return view('obats.index', compact('obats', 'kemasans', 'satuans', 'bentukSediaans'));
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
            'kode_obat' => 'required|string|max:50',
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'string|max:15',
            'kekuatan_obat' => 'string|max:100',
            'kemasan_obat' => 'required|exists:kemasans,id',
            'bentuk_sediaan' => 'nullable|exists:bentuk_sediaans,id',
            'exp_obat' => 'nullable|date',
            'satuan' => 'required|exists:satuans,id',
            'foto_obat' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok_awal' => 'required|integer|min:0',
        ]);
    
        // Mengunggah foto obat
        $filePath = null;
        if ($request->hasFile('foto_obat')) {
            $file = $request->file('foto_obat');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('Foto-Obat'), $fileName);
            $filePath = 'Foto-Obat/' . $fileName;
        }
    
        // Menyimpan data obat ke tabel obats
        $obat = new Obat();
        $obat->kode_obat = $request->kode_obat;
        $obat->nama_obat = $request->nama_obat;
        $obat->jenis_obat = $request->jenis_obat;
        $obat->kekuatan_obat = $request->kekuatan_obat;
        $obat->kemasan_id = $request->kemasan_obat;
        $obat->bentuk_sediaan_id = $request->bentuk_sediaan;
        $obat->satuan_id = $request->satuan;
        $obat->exp_obat = $request->exp_obat;
        $obat->stok_obat = $request->stok_awal;
        $obat->foto_obat = $filePath ?? null;
        $obat->save();
    
        return redirect()->route('data-obat.index')->with('success', 'Data Obat berhasil disimpan.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $obat = Obat::with(['stokMasuks', 'stokKeluars', 'kemasan', 'bentukSediaan', 'satuan']) ->findOrFail($id);

        $kemasans = Kemasan::all();
        $satuans = Satuan::all();
        $bentukSediaans = BentukSediaan::all();

        return view('obats.show', compact('obat', 'kemasans', 'satuans', 'bentukSediaans'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Obat $obat)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_obat' => 'required|string|max:255',
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'nullable|string',
            'kekuatan_obat' => 'nullable|string',
            'kemasan_obat' => 'nullable|integer',
            'bentuk_sediaan' => 'nullable|integer',
            'exp_obat' => 'nullable|date',
            'satuan' => 'nullable|integer',
            'stok_awal' => 'nullable|integer|min:0',
            'sisa_obat' => 'nullable|integer|min:0',
        ]);

        // Temukan data obat berdasarkan ID
        $obat = Obat::findOrFail($id);

        // Update data obat
        $obat->update([
            'kode_obat' => $request->kode_obat,
            'nama_obat' => $request->nama_obat,
            'jenis_obat' => $request->jenis_obat,
            'kekuatan_obat' => $request->kekuatan_obat,
            'kemasan_obat' => $request->kemasan_obat,
            'bentuk_sediaan' => $request->bentuk_sediaan,
            'exp_obat' => $request->exp_obat,
            'satuan' => $request->satuan,
            'stok_awal' => $request->stok_awal,
            'sisa_obat' => $request->sisa_obat,
        ]);

        return redirect()->route('data-obat.index')->with('success', 'Data obat berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Obat::find($id)->delete();

        return redirect()->route('data-obat.index')
            ->with('success', 'Data Obat Berhasil dihapus');
    }
}
