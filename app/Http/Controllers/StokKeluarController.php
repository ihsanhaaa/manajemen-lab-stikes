<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BentukSediaan;
use App\Models\Kemasan;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\Semester;
use App\Models\StokKeluar;
use Illuminate\Http\Request;

class StokKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $obat_keluars = StokKeluar::orderBy('tanggal_keluar', 'desc')->get();
        $kemasans = Kemasan::all();
        $satuans = Satuan::all();
        $bentukSediaans = BentukSediaan::all();
        $obats = Obat::orderBy('nama_obat', 'asc')->get();

        return view('obat-keluars.index', compact('obat_keluars', 'kemasans', 'satuans', 'bentukSediaans', 'obats'));
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
        // Ambil semester aktif
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan.');
        }

        // Validasi input dari form
        $validated = $request->validate([
            'obat_id' => 'required',
            'jumlah_pemakaian' => 'required|integer|min:1',
            
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        $obat = Obat::find($request->obat_id);

        if ($request->jumlah_pemakaian > $obat->stok_obat) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        // Buat catatan stok keluar
        StokKeluar::create([
            'semester_id' => $semesterAktif->id,
            'obat_id' => $request->obat_id,
            'jumlah_pemakaian' => $request->jumlah_pemakaian,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan,
        ]);

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

        $obat->save();

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

    public function updateTanggalKeluar(Request $request, $id)
    {
        $request->validate([
            'tanggal_keluar' => 'required|date',
        ]);

        $stokKeluar = StokKeluar::findOrFail($id);
        $stokKeluar->tanggal_keluar = $request->tanggal_keluar;
        $stokKeluar->save();

        return response()->json(['success' => true, 'message' => 'Tanggal keluar berhasil diperbarui.']);
    }
}
