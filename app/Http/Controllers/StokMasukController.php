<?php

namespace App\Http\Controllers;

use App\Imports\ObatImport;
use App\Imports\ObatMasukImport;
use App\Models\BentukSediaan;
use App\Models\Foto;
use App\Models\Kemasan;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\StokMasuk;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StokMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stokMasuks = StokMasuk::all();
        $kemasans = Kemasan::all();
        $satuans = Satuan::all();
        $bentukSediaans = BentukSediaan::all();

        return view('stok-masuks.index', compact('stokMasuks', 'kemasans', 'satuans', 'bentukSediaans'));
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
        $validated = $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'tanggal_masuk' => 'required|date',
        ]);

        // Buat catatan stok masuk
        StokMasuk::create($validated);

        // Perbarui stok obat
        $obat = Obat::find($request->obat_id);
        $obat->increment('stok_obat', $request->jumlah_masuk);

        return redirect()->route('stok_masuk.index')->with('success', 'Stok obat berhasil ditambah.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'jumlah_masuk' => 'required|integer',
            'tanggal_masuk' => 'required|date',
        ]);

        Excel::import(new ObatMasukImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data obat berhasil diimpor!');
    }

    public function importExcelBaru(Request $request)
    {
        // Validasi request file dan foto
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'tanggal_masuk' => 'required|date',
            'foto_path.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048' // Validasi untuk setiap file foto
        ]);

        try {
            // Simpan nilai tambahan ke session
            session([
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            // Periksa apakah file valid
            if ($request->hasFile('file')) {
                // Jalankan import data excel
                Excel::import(new ObatMasukImport, $request->file('file'));
            } else {
                // Mengembalikan error jika file tidak ada
                return redirect()->back()->with('error', 'File Excel tidak ditemukan.');
            }

            // Hapus session data setelah proses selesai
            session()->forget('tanggal_masuk');

            // Kembalikan respon sukses
            return redirect()->back()->with('success', 'Data obat berhasil diimpor!');
            
        } catch (\Exception $e) {
            // Tangani error jika terjadi kesalahan dalam proses import
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $obat = Obat::with(['kemasan', 'bentukSediaan', 'satuan'])->findOrFail($id);

        return view('stok-masuks.show', compact('obat'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StokMasuk $stokMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StokMasuk $stokMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StokMasuk $stokMasuk)
    {
        //
    }
}
