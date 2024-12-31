<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BahanKeluar;
use App\Models\Semester;
use Illuminate\Http\Request;

class BahanKeluarController extends Controller
{
    public function index()
    {
        $bahan_keluars = BahanKeluar::all();

        $bahans = Bahan::all();

        return view('bahan-keluars.index', compact('bahan_keluars', 'bahans'));
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
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan');
        }

        // Validasi input dari form
        $validated = $request->validate([
            'bahan_id' => 'required',
            'jumlah_pemakaian' => 'required|integer|min:1',
            
            'tanggal_keluar' => 'required|date',
            'keterangan' => 'required|string|max:255',
        ]);

        $bahan = Bahan::find($request->bahan_id);

        if ($request->jumlah_pemakaian > $bahan->stok_bahan) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi');
        }

        // Buat catatan stok keluar
        BahanKeluar::create([
            'semester_id' => $semesterAktif->id,
            'bahan_id' => $request->bahan_id,
            'jumlah_pemakaian' => $request->jumlah_pemakaian,
            'tanggal_keluar' => $request->tanggal_keluar,
            'keterangan' => $request->keterangan,
        ]);

        if ($bahan->stok_bahan > 0) {
            // Jika stok_bahan ada, kurangi stok_bahan terlebih dahulu
            if ($bahan->stok_bahan >= $request->jumlah_pemakaian) {
                $bahan->stok_bahan -= $request->jumlah_pemakaian;
            } else {
                // Jika stok_bahan kurang dari jumlah pemakaian
                $remaining = $request->jumlah_pemakaian - $bahan->stok_bahan;
                $bahan->stok_bahan = 0; // Set stok_bahan ke 0
                $bahan->stok_bahan -= $remaining; // Kurangi sisanya dari stok_bahan
            }
        } else {
            // Jika stok_bahan nol, kurangi langsung dari stok_bahan
            $bahan->stok_bahan -= $request->jumlah_pemakaian;
        }

        $bahan->save();

        return redirect()->route('data-bahan-keluar.index')->with('success', 'Stok obat berhasil dikurangi');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'keterangan' => 'required|string|max:255',
        ]);

        $bahanKeluar = BahanKeluar::findOrFail($id);
        $bahanKeluar->keterangan = $request->keterangan;
        $bahanKeluar->save();

        return redirect()->back()->with('success', 'Keterangan berhasil diperbarui');
    }

    public function updateTanggalKeluar(Request $request, $id)
    {
        $request->validate([
            'tanggal_keluar' => 'required|date',
        ]);

        $bahanKeluar = BahanKeluar::findOrFail($id);
        $bahanKeluar->tanggal_keluar = $request->tanggal_keluar;
        $bahanKeluar->save();

        return response()->json(['success' => true, 'message' => 'Tanggal keluar berhasil diperbarui.']);
    }
}
