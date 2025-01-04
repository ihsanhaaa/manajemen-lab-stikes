<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\AlatRusak;
use App\Models\Semester;
use Illuminate\Http\Request;

class AlatRusakController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alat_rusaks = AlatRusak::orderBy('tanggal_rusak', 'desc')->get();
        $alats = Alat::all();

        return view('alat-rusaks.index', compact('alat_rusaks', 'alats'));
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
            'alat_id' => 'required',
            'jumlah_rusak' => 'required|integer|min:1',
            'nama_perusak' => 'required|string|max:50',
            'tanggal_rusak' => 'required|date',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $alat = Alat::find($request->alat_id);

        if ($request->jumlah_rusak > $alat->stok) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        // Buat catatan stok keluar
        AlatRusak::create([
            'semester_id' => $semesterAktif->id,
            'alat_id' => $request->alat_id,
            'jumlah_rusak' => $request->jumlah_rusak,
            'tanggal_rusak' => $request->tanggal_rusak,
            'nama_perusak' => $request->nama_perusak,
            'keterangan' => $request->keterangan,
        ]);

        if ($alat->stok > 0) {
            // Jika stok ada, kurangi stok terlebih dahulu
            if ($alat->stok >= $request->jumlah_rusak) {
                $alat->stok -= $request->jumlah_rusak;
            } else {
                // Jika stok kurang dari jumlah pemakaian
                $remaining = $request->jumlah_rusak - $alat->stok;
                $alat->stok = 0; // Set stok ke 0
                $alat->stok -= $remaining; // Kurangi sisanya dari stok
            }
        } else {
            // Jika stok nol, kurangi langsung dari stok
            $alat->stok -= $request->jumlah_rusak;
        }

        $alat->save();

        return redirect()->route('data-alat-rusak.index')->with('success', 'Data barang rusak berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(AlatRusak $alatRusak)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlatRusak $alatRusak)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateGantiAlat($id)
    {
        // Aktifkan semester yang dipilih
        $alat_rusak = AlatRusak::findOrFail($id);
        $alat_rusak->update(['status' => true]);

        return redirect()->back()->with('success', 'Data alat rusak sudah diganti');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlatRusak $alatRusak)
    {
        //
    }

    public function updateTanggalRusak(Request $request, $id)
    {
        $request->validate([
            'tanggal_rusak' => 'required|date',
        ]);

        $alatRusak = AlatRusak::findOrFail($id);
        $alatRusak->tanggal_rusak = $request->tanggal_rusak;
        $alatRusak->save();

        return response()->json(['success' => true, 'message' => 'Tanggal rusak berhasil diperbarui.']);
    }
}
