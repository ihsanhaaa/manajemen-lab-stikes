<?php

namespace App\Http\Controllers;

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
        // dd($request);

        $request->validate([
            'nama_berkas' => 'required|string|max:255',
            'nomor_berkas' => 'required|string|max:255',
            'tanggal_berkas' => 'required|date',
            'kategori_berkas' => 'required',
            'stakeholder' => 'string',
            'tanggal_mulai' => 'date',
            'tanggal_berakhir' => 'date',
            'file_berkas' => 'required|mimes:pdf,docx|max:2048',
        ]);

        $file = $request->file('file_berkas');
        if ($file) {

            $cleanedName = preg_replace('/[^A-Za-z0-9\-]/', '_', $request->nama_berkas);
            $cleanedKategori = preg_replace('/[^A-Za-z0-9\-]/', '_', $request->kategori_berkas);

            $filename = $cleanedKategori . '-' . $cleanedName . '-' . time() . '.' . $file->getClientOriginalExtension();
            $path = 'Berkas/' . $filename;

            $file->move(public_path('Berkas'), $filename);

            $surat = new Surat();
            $surat->nama_berkas = $request->input('nama_berkas');
            $surat->nomor_berkas = $request->input('nomor_berkas');
            $surat->kategori_berkas = $request->input('kategori_berkas');

            $surat->stakeholder = $request->input('stakeholder');
            $surat->tanggal_mulai = $request->input('tanggal_mulai');
            $surat->tanggal_berakhir = $request->input('tanggal_berakhir');

            $surat->tanggal_berkas = $request->input('tanggal_berkas');
            $surat->file_berkas = $filename;
            $surat->save();

            return back()->with('success', 'Data surat berhasil ditambahkan');
        }

        return back()->with('error', 'Gagal menambahkan Data Surat.');
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
        $surat_masuk = Surat::findOrFail($id);

        // Update data obat
        $surat_masuk->update([
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

        return redirect()->route('data-surat-masuk.show', $surat_masuk->id)->with('success', 'Data obat berhasil diperbarui');
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
}
