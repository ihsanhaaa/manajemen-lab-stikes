<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\ObatPengajuanBahan;
use App\Models\PengajuanBahan;
use App\Models\Satuan;
use App\Models\Semester;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanBahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        $obats = Obat::with('stokKeluars')->get();
        $pengajuanbahans = PengajuanBahan::all();
        $satuans = Satuan::all();

        return view('pengajuan-bahans.index', compact('obats', 'satuans', 'pengajuanbahans', 'semesterAktif'));
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
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('alert', 'Tidak ada semester yang aktif.');
        }

        // dd($request);
        // Validasi data utama
        $validatedData = $request->validate([
            'semester_id' => $semesterAktif->id,
            'anggota_kelompok' => 'required|string',
            'nim_kelompok' => 'required|string',
            'kelas' => 'required|string',
            'tanggal_praktikum' => 'required|date',
            'nama_praktikum' => 'required|string',
            'obat_id.*' => 'required|exists:obats,id',
            'jumlah_pemakaian.*' => 'required|integer|min:1',
            'satuan.*' => 'nullable|exists:satuans,id',
            'jenis_obat.*' => 'nullable|string|in:Cair,Padat',
            'keterangan.*' => 'nullable|string',
        ]);

        // Simpan data utama ke tabel pengajuan_bahans
        $pengajuanBahan = PengajuanBahan::create([
            'user_id' => Auth::user()->id,
            'nama_mahasiswa' => $validatedData['anggota_kelompok'],
            'kelompok' => $validatedData['nim_kelompok'],
            'kelas' => $validatedData['kelas'],
            'tanggal_pelaksanaan' => $validatedData['tanggal_praktikum'],
            'nama_praktikum' => $validatedData['nama_praktikum'],
            'status' => false, // Status awal diset ke false
        ]);
    
        // Loop untuk menyimpan data obat terkait pengajuan
        foreach ($validatedData['obat_id'] as $index => $obatId) {
            ObatPengajuanBahan::create([
                'obat_id' => $obatId,
                'pengajuan_bahan_id' => $pengajuanBahan->id,
                'jumlah_pemakaian' => $validatedData['jumlah_pemakaian'][$index],
                // Optional fields (satuan, jenis_obat, keterangan)
                'satuan' => $validatedData['satuan'][$index] ?? null,
                'jenis_obat' => $validatedData['jenis_obat'][$index] ?? null,
                'keterangan' => $validatedData['keterangan'][$index] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Pengajuan bahan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajuanBahan = PengajuanBahan::with('obatPengajuanBahans')->findOrFail($id);

        return view('pengajuan-bahans.show', compact('pengajuanBahan'));

    }

    public function getSisaStok($id)
    {
        $obat = Obat::findOrFail($id);
        
        return response()->json(['sisa_stok' => $obat->sisa_obat]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanBahan $pengajuanBahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update($id)
    // {
    //     $pengajuanBahan = PengajuanBahan::findOrFail($id);
    //     // dd($pengajuanBahan);

    //     $pengajuanBahan->status = true;
    //     $pengajuanBahan->save();

    //     // store data obat pengajuan bahan ke tabel stok keluar

    //     // update tabel obat

    //     return redirect()->route('pengajuan-bahan.index')
    //         ->with('success', 'Pengajuan Bahan Sudah di ACC');
    // }

    public function update($id)
    {
        $pengajuanBahan = PengajuanBahan::findOrFail($id);

        // Set status pengajuan menjadi true
        $pengajuanBahan->status = true;
        $pengajuanBahan->save();

        // Ambil semua data obat terkait dengan pengajuan bahan ini
        $obatPengajuanBahans = $pengajuanBahan->obatPengajuanBahans;

        // Simpan data ke tabel stok_keluars dan update stok obat
        foreach ($obatPengajuanBahans as $obatPengajuanBahan) {
            // Menyimpan data ke stok_keluars
            StokKeluar::create([
                'obat_id' => $obatPengajuanBahan->obat_id,
                'jumlah_pemakaian' => $obatPengajuanBahan->jumlah_pemakaian,
                'tanggal_keluar' => now(), // Tanggal keluar bisa menggunakan tanggal saat ini atau tanggal lain yang Anda tentukan
            ]);

            // Update stok pada tabel obats
            $obat = Obat::find($obatPengajuanBahan->obat_id);
            if ($obat) {
                // Asumsi `stok` adalah field di tabel `obats` yang menyimpan jumlah stok
                $obat->sisa_obat -= $obatPengajuanBahan->jumlah_pemakaian;
                $obat->save();
            }
        }

        return redirect()->route('pengajuan-bahan.index')
            ->with('success', 'Pengajuan Bahan Sudah di ACC');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        PengajuanBahan::find($id)->delete();

        return redirect()->route('pengajuan-bahan.index')
            ->with('success', 'Data Pengajuan Bahan Berhasil dihapus');
    }
}
