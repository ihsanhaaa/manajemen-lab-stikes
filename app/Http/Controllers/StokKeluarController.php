<?php

namespace App\Http\Controllers;

use App\Models\BentukSediaan;
use App\Models\Kemasan;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\StokKeluar;
use Illuminate\Http\Request;

class StokKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obatKeluars = StokKeluar::all();
        $kemasans = Kemasan::all();
        $satuans = Satuan::all();
        $bentukSediaans = BentukSediaan::all();
        $obats = Obat::all();

        return view('obat-keluars.index', compact('obatKeluars', 'kemasans', 'satuans', 'bentukSediaans', 'obats'));
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
        // Validasi input dari form
        $validated = $request->validate([
            'obat_id' => 'required',
            'jumlah_pemakaian' => 'required|integer|min:1',
            'tanggal_keluar' => 'required|date',
        ]);

        // Ambil data obat untuk dicek stoknya
        $obat = Obat::find($request->obat_id);

        // Cek apakah stok mencukupi (baik stok_obat atau sisa_obat)
        if (($obat->stok_obat + $obat->sisa_obat) < $request->jumlah_pemakaian) {
            return back()->withErrors(['stok_obat' => 'Stok tidak mencukupi']);
        }

        // Buat catatan stok keluar
        StokKeluar::create([
            'obat_id' => $request->obat_id,
            'jumlah_pemakaian' => $request->jumlah_pemakaian,
            'satuan' => $request->satuan,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan, // jika ada kolom keterangan
        ]);

        // Pengurangan stok berdasarkan kondisi sisa_obat
        if ($obat->sisa_obat > 0) {
            // Jika sisa_obat ada, kurangi sisa_obat terlebih dahulu
            if ($obat->sisa_obat >= $request->jumlah_pemakaian) {
                $obat->sisa_obat -= $request->jumlah_pemakaian;
            } else {
                // Jika sisa_obat kurang dari jumlah pemakaian
                $remaining = $request->jumlah_pemakaian - $obat->sisa_obat;
                $obat->sisa_obat = 0; // Set sisa_obat ke 0
                $obat->stok_obat -= $remaining; // Kurangi sisanya dari stok_obat
            }
        } else {
            // Jika sisa_obat nol, kurangi langsung dari stok_obat
            $obat->sisa_obat -= $request->jumlah_pemakaian;
        }

        // Simpan perubahan
        $obat->save();

        // Redirect dengan pesan sukses
        return redirect()->route('data-obat-keluar.index')->with('success', 'Stok obat berhasil dikurangi.');
    }


    /**
     * Display the specified resource.
     */
    public function show(StokKeluar $stokKeluar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StokKeluar $stokKeluar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StokKeluar $stokKeluar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StokKeluar $stokKeluar)
    {
        //
    }
}