<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class BahanController extends Controller
{
    public function index()
    {
        $bahans = Bahan::with('bahanKeluars')->get();

        return view('bahans.index', compact('bahans'));
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
        // dd($request);
        $request->validate([
            'kode_bahan' => 'required|string|max:50',
            'nama_bahan' => 'required|string|max:255',
            'formula' => 'nullable|string|max:15',
            'exp_bahan' => 'nullable|date',
            'jenis_bahan' => 'required|string|max:10',
            'foto_path' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:3048',
            'stok_bahan' => 'required|integer|min:0',
        ]);
    
        // Mengunggah foto bahan
        $filePath = null;
        if ($request->hasFile('foto_path')) {
            $file = $request->file('foto_path');
            $fileName = time() . '-' . $file->getClientOriginalName();
            $file->move(public_path('foto-bahan'), $fileName);
            $filePath = 'foto-bahan/' . $fileName;
        }
    
        // Menyimpan data bahan ke tabel bahans
        $bahan = new Bahan();
        $bahan->kode_bahan = $request->kode_bahan;
        $bahan->nama_bahan = $request->nama_bahan;
        $bahan->formula = $request->formula;
        $bahan->exp_bahan = $request->exp_bahan;
        $bahan->jenis_bahan = $request->jenis_bahan;
        $bahan->foto_path = $filePath ?? null;
        $bahan->stok_bahan = $request->stok_bahan;
        $bahan->save();
    
        return redirect()->route('data-bahan.index')->with('success', 'Data Bahan berhasil disimpan.');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bahan = Bahan::with(['bahanMasuks', 'bahanKeluars']) ->findOrFail($id);

        return view('bahans.show', compact('bahan'));

    }

    public function filterByStatus($status)
    {
        $currentDate = Carbon::now();
        $bahans = [];

        // Tentukan query berdasarkan status
        if ($status === 'belum-expired') {
            $bahans = Bahan::where('exp_obat', '>', $currentDate->copy()->addWeek())->get();
        } elseif ($status === 'mendekati-expired') {
            $bahans = Bahan::where('exp_obat', '>', $currentDate)
                        ->where('exp_obat', '<=', $currentDate->copy()->addWeek())
                        ->get();
        } elseif ($status === 'expired') {
            $bahans = Bahan::where('exp_obat', '<', $currentDate)->get();
        } else {
            abort(404);
        }

        return view('bahans.status', compact('bahans', 'status'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bahan $bahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'kode_bahan' => 'required|string|max:255',
            'nama_bahan' => 'required|string|max:255',
            'formula' => 'required|string|max:255',
            'jenis_bahan' => 'required|in:Cairan,Padat',
            'satuan' => 'required|string|max:255',
            'exp_bahan' => 'nullable|date',
            'stok_bahan' => 'nullable|min:0',
        ]);

        $bahan = Bahan::findOrFail($id);

        // Update data
        $bahan->update([
            'kode_bahan' => $validated['kode_bahan'],
            'nama_bahan' => $validated['nama_bahan'],
            'formula' => $validated['formula'],
            'jenis_bahan' => $validated['jenis_bahan'],
            'satuan' => $validated['satuan'],
            'exp_bahan' => $validated['exp_bahan'],
            'stok_bahan' => $validated['stok_bahan'],
        ]);

        return redirect()->route('data-bahan.show', $bahan->id)->with('success', 'Data bahan berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Bahan::find($id)->delete();

        return redirect()->route('data-bahan.index')
            ->with('success', 'Data Bahan Berhasil dihapus');
    }

    public function uploadPhotoDetail(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $bahan = Bahan::findOrFail($id);

        // Hapus foto lama jika ada
        if ($bahan->foto_path && file_exists(public_path($bahan->foto_path))) {
            unlink(public_path($bahan->foto_path));
        }

        // Proses unggah foto baru
        $path = 'foto-bahan/';
        $new_name = 'bahan-' . $id . '-' . date('Ymd') . '-' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

        $request->file('photo')->move(public_path($path), $new_name);

        // Update path foto pada tabel `bahans`
        $bahan->update([
            'foto_path' => $path . $new_name
        ]);

        return redirect()->route('data-bahan.show', $bahan->id)->with('success', 'Foto berhasil diperbarui');
    }

    public function deletePhoto($id)
    {
        $bahan = Bahan::findOrFail($id);

        // Hapus file foto dari direktori jika ada
        if ($bahan->foto_path && file_exists(public_path($bahan->foto_path))) {
            unlink(public_path($bahan->foto_path));
        }

        // Set kolom foto_path menjadi null
        $bahan->update(['foto_path' => null]);

        return redirect()->route('data-bahan.show', $bahan->id)->with('success', 'Foto berhasil dihapus');
    }

    public function exportPdf()
    {
        $bahans = Bahan::orderBy('stok_bahan')->get();

        $pdf = PDF::loadView('bahans.laporan', compact('bahans'))
            ->setPaper('a4', 'potrait');

        // Format nama file dengan tanggal saat ini
        $currentDate = Carbon::now()->format('dmY');
        $fileName = "Laporan_Bahan-{$currentDate}.pdf";

        // Unduh file dengan nama yang sudah diformat
        return $pdf->download($fileName);
    }
}
