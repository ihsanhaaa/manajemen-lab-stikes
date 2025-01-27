<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use PDF;

class AlatController extends Controller
{
    public function index()
    {
        $alats = Alat::with('alatRusaks')->get();

        return view('alats.index', compact('alats'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'stok' => 'required|string|max:255',
            'ukuran' => 'nullable|string|max:255',
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

    public function show($id)
    {
        $alat = Alat::with(['alatMasuks', 'alatRusaks']) ->findOrFail($id);

        return view('alats.show', compact('alat'));
    }

    public function destroy($id)
    {
        Alat::find($id)->delete();

        return redirect()->route('data-alat.index')
            ->with('success', 'Data alat berhasil dihapus');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'ukuran' => 'nullable|string|max:20',
            'stok' => 'nullable|string',
            'penyimpanan' => 'required|string|max:50',
            'letak_aset' => 'required|string|max:50',
        ]);

        // Temukan data obat berdasarkan ID
        $alat = Alat::findOrFail($id);

        // Update data obat
        $alat->update([
            'nama_barang' => $request->nama_barang,
            'ukuran' => $request->ukuran,
            'stok' => $request->stok,
            'penyimpanan' => $request->penyimpanan,
            'letak_aset' => $request->letak_aset,
        ]);

        return redirect()->route('data-alat.show', $alat->id)->with('success', 'Data alat berhasil diperbarui');
    }

    public function exportPdf()
    {
        $alats = Alat::orderBy('stok')->get();

        $pdf = PDF::loadView('alats.laporan', compact('alats'))
            ->setPaper('a4', 'potrait');

        // Format nama file dengan tanggal saat ini
        $currentDate = Carbon::now()->format('dmY');
        $fileName = "Laporan_Alat-{$currentDate}.pdf";

        // Unduh file dengan nama yang sudah diformat
        return $pdf->download($fileName);
    }
}
