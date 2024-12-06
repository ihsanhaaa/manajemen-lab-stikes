<?php

namespace App\Http\Controllers;

use App\Models\FileSurat;
use App\Models\Surat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuratController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $surat_masuks = Surat::where('kategori_berkas', 'Surat Masuk')->get();

        return view('surat-masuks.index', compact('surat_masuks'));
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
        $validatedData = $request->validate([
            'nama_berkas' => 'required|string|max:255',
            'nomor_berkas' => 'required|string|max:255',
            'tanggal_berkas' => 'required|date',
            'kategori_berkas' => 'required',
            'file_berkas.*' => 'required|mimes:pdf,docx,jpg,jpeg,png|max:3048',
        ]);

        if ($request->kategori_berkas === 'Surat MOU') {
            $request->validate([
                'stakeholder' => 'required|string|max:255',
                'tanggal_mulai' => 'required|date',
                'tanggal_berakhir' => 'required|date|after_or_equal:tanggal_mulai',
            ]);
        }

        $surat = new Surat();
        $surat->nama_berkas = $request->input('nama_berkas');
        $surat->nomor_berkas = $request->input('nomor_berkas');
        $surat->kategori_berkas = $request->input('kategori_berkas');
        $surat->stakeholder = $request->input('stakeholder');
        $surat->tanggal_mulai = $request->input('tanggal_mulai');
        $surat->tanggal_berakhir = $request->input('tanggal_berakhir');
        $surat->tanggal_berkas = $request->input('tanggal_berkas');
        $surat->save();

        if ($request->hasFile('file_berkas')) {
            foreach ($request->file('file_berkas') as $file) {
                $cleanedName = preg_replace('/[^A-Za-z0-9\-]/', '_', $request->nama_berkas);
                $cleanedKategori = preg_replace('/[^A-Za-z0-9\-]/', '_', $request->kategori_berkas);

                $filename = $cleanedKategori . '-' . $cleanedName . '-' . time() . '-' . $file->getClientOriginalName();
                $file->move(public_path('Berkas'), $filename);

                $fileSurat = new FileSurat();
                $fileSurat->surat_id = $surat->id;
                $fileSurat->file_path = 'Berkas/' . $filename;
                $fileSurat->save();
            }
        }

        return back()->with('success', 'Data surat berhasil ditambahkan.');
    }

    

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $surat_masuk = Surat::findOrFail($id);

        return view('surat-masuks.show', compact('surat_masuk', 'kemasans', 'satuans', 'bentukSediaans'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Surat $surat_masuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $suratMasuk = Surat::find($id);
        $suratMasuk->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data berhasil diperbarui!',
            'data' => $suratMasuk,
        ]);
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Surat::find($id)->delete();

        return redirect()->route('data-surat-masuk.index')
            ->with('success', 'Data Surat Berhasil dihapus');
    }

    public function uploadPhotoDetail(Request $request, $id)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $surat_masuk = Surat::findOrFail($id);

        // Hapus foto lama jika ada
        if ($surat_masuk->foto_path && file_exists(public_path($surat_masuk->foto_path))) {
            unlink(public_path($surat_masuk->foto_path));
        }

        // Proses unggah foto baru
        $path = 'foto-obat/';
        $new_name = 'obat-' . $id . '-' . date('Ymd') . '-' . uniqid() . '.' . $request->file('photo')->getClientOriginalExtension();

        $request->file('photo')->move(public_path($path), $new_name);

        // Update path foto pada tabel `surat-masuks`
        $surat_masuk->update([
            'foto_path' => $path . $new_name
        ]);

        return redirect()->route('data-surat-masuk.show', $surat_masuk->id)->with('success', 'Foto berhasil diperbarui');
    }

    public function updateKategori(Request $request, $id)
    {
        $request->validate([
            'kategori_berkas' => 'required|in:Surat Masuk,Surat Keluar,Surat SK,Surat Penting,Surat Arsip,Surat MOU',
        ]);

        $surat = Surat::findOrFail($id);
        $surat->kategori_berkas = $request->kategori_berkas;
        $surat->save();

        return response()->json(['success' => 'Kategori surat berhasil diubah!']);
    }
}
