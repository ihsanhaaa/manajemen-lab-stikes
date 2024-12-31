<?php

namespace App\Http\Controllers;

use App\Models\BentukSediaan;
use App\Models\Foto;
use App\Models\Kemasan;
use App\Models\Obat;
use App\Models\Satuan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

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
            'foto_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'stok_awal' => 'required|integer|min:0',
        ]);
    
        // Mengunggah foto obat
        $filePath = null;
        if ($request->hasFile('foto_path')) {
            $file = $request->file('foto_path');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('foto-obat'), $fileName);
            $filePath = 'foto-obat/' . $fileName;
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
        $obat->foto_path = $filePath ?? null;
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

    public function filterByStatus($status)
    {
        $currentDate = Carbon::now();
        $obats = [];

        // Tentukan query berdasarkan status
        if ($status === 'belum-expired') {
            $obats = Obat::where('exp_obat', '>', $currentDate->copy()->addWeek())->get();
        } elseif ($status === 'mendekati-expired') {
            $obats = Obat::where('exp_obat', '>', $currentDate)
                        ->where('exp_obat', '<=', $currentDate->copy()->addWeek())
                        ->get();
        } elseif ($status === 'expired') {
            $obats = Obat::where('exp_obat', '<', $currentDate)->get();
        } else {
            abort(404); // Jika status tidak valid, kembalikan halaman 404
        }

        return view('obats.status', compact('obats', 'status'));
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
        $validated = $request->validate([
            'kode_obat' => 'required|string|max:255',
            'nama_obat' => 'required|string|max:255',
            'kekuatan_obat' => 'nullable|string|max:255',
            'kemasan_obat' => 'nullable|exists:kemasans,id',
            'bentuk_sediaan' => 'nullable|exists:bentuk_sediaans,id',
            'satuan' => 'nullable|exists:satuans,id',
            'exp_obat' => 'nullable|date',
            'stok_obat' => 'required|integer|min:0',
        ]);
    
        $obat = Obat::findOrFail($id);
        $obat->update([
            'kode_obat' => $validated['kode_obat'],
            'nama_obat' => $validated['nama_obat'],
            'jenis_obat' => $validated['jenis_obat'],
            'kekuatan_obat' => $validated['kekuatan_obat'],
            'kemasan_id' => $validated['kemasan_obat'],
            'bentuk_sediaan_id' => $validated['bentuk_sediaan'],
            'satuan_id' => $validated['satuan'],
            'exp_obat' => $validated['exp_obat'],
            'stok_obat' => $validated['stok_obat'],
        ]);

        return redirect()->route('data-obat.show', $obat->id)->with('success', 'Data obat berhasil diperbarui');
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

    public function uploadPhotoDetail(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $obat = Obat::findOrFail($id);

        // Hapus foto lama jika ada
        if ($obat->foto_path && file_exists(public_path($obat->foto_path))) {
            unlink(public_path($obat->foto_path));
        }

        // Proses unggah foto baru
        $path = 'foto-obat/';
        $new_name = 'obat-' . $id . '-' . date('Ymd') . '-' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

        $request->file('photo')->move(public_path($path), $new_name);

        // Update path foto pada tabel `obats`
        $obat->update([
            'foto_path' => $path . $new_name
        ]);

        return redirect()->route('data-obat.show', $obat->id)->with('success', 'Foto berhasil diperbarui');
    }

    public function deletePhoto($id)
    {
        $obat = Obat::findOrFail($id);

        // Hapus file foto dari direktori jika ada
        if ($obat->foto_path && file_exists(public_path($obat->foto_path))) {
            unlink(public_path($obat->foto_path));
        }

        // Set kolom foto_path menjadi null
        $obat->update(['foto_path' => null]);

        return redirect()->route('data-obat.show', $obat->id)->with('success', 'Foto berhasil dihapus');
    }

    public function exportPdf()
    {
        $obats = Obat::orderBy('stok_obat')->get();

        $pdf = PDF::loadView('obats.laporan', compact('obats'))
            ->setPaper('a4', 'potrait');

        // Format nama file dengan tanggal saat ini
        $currentDate = Carbon::now()->format('dmY'); // Format: 12112024
        $fileName = "Laporan_Obat-{$currentDate}.pdf";

        // Unduh file dengan nama yang sudah diformat
        return $pdf->download($fileName);
    }

}
