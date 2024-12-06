<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BahanKeluar;
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
        $bahans = Bahan::with('bahanKeluars')->get();

        $pengajuanbahans = PengajuanBahan::all();
        $satuans = Satuan::all();

        return view('pengajuan-bahans.index', compact('obats', 'bahans', 'satuans', 'pengajuanbahans', 'semesterAktif'));
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
            'anggota_kelompok' => 'required|string',
            'nim_kelompok' => 'required|string',
            'kelas' => 'required|string',
            'tanggal_praktikum' => 'required|date',
            'nama_praktikum' => 'required|string',
            'tipe.*' => 'in:bahan,obat',
            'obat_id.*' => 'nullable|exists:obats,id',
            'bahan_id.*' => 'nullable|exists:bahans,id',
            'jumlah_pemakaian.*' => 'required|integer|min:1',
            'satuan.*' => 'required',
            'jenis_obat.*' => 'nullable|string|in:Cair,Padat',
            'keterangan.*' => 'nullable|string',
        ]);

        // Simpan data utama ke tabel pengajuan_bahans
        $pengajuanBahan = PengajuanBahan::create([
            'semester_id' => $semesterAktif->id,
            'user_id' => Auth::user()->id,
            'nama_mahasiswa' => $validatedData['anggota_kelompok'],
            'kelompok' => $validatedData['nim_kelompok'],
            'kelas' => $validatedData['kelas'],
            'tanggal_pelaksanaan' => $validatedData['tanggal_praktikum'],
            'nama_praktikum' => $validatedData['nama_praktikum'],
            'status' => false,
        ]);

        if (isset($validatedData['tipe']) && is_array($validatedData['tipe'])) {
            foreach ($validatedData['tipe'] as $index => $tipe) {
                if ($tipe == 'bahan') {
                    // Simpan data bahan
                    if (isset($validatedData['bahan_id'][$index])) {
                        ObatPengajuanBahan::create([
                            'semester_id' => $semesterAktif->id,
                            'user_id' => Auth::user()->id,
                            'bahan_id' => $validatedData['bahan_id'][$index],
                            'pengajuan_bahan_id' => $pengajuanBahan->id,
                            'jumlah_pemakaian' => $validatedData['jumlah_pemakaian'][$index],
                            'satuan' => $validatedData['satuan'][$index] ?? null,
                            'tipe' => $validatedData['tipe'][$index] ?? null,
                            'jenis_obat' => $validatedData['jenis_obat'][$index] ?? null,
                            'keterangan' => $validatedData['keterangan'][$index] ?? null,
                        ]);
                    }
                } elseif ($tipe == 'obat') {
                    // Simpan data obat
                    if (isset($validatedData['obat_id'][$index])) {
                        ObatPengajuanBahan::create([
                            'semester_id' => $semesterAktif->id,
                            'user_id' => Auth::user()->id,
                            'obat_id' => $validatedData['obat_id'][$index],
                            'pengajuan_bahan_id' => $pengajuanBahan->id,
                            'jumlah_pemakaian' => $validatedData['jumlah_pemakaian'][$index],
                            'satuan' => $validatedData['satuan'][$index] ?? null,
                            'tipe' => $validatedData['tipe'][$index] ?? null,
                            'jenis_obat' => $validatedData['jenis_obat'][$index] ?? null,
                            'keterangan' => $validatedData['keterangan'][$index] ?? null,
                        ]);
                    }
                }
            }
        } else {
            // Tangani kasus ketika 'tipe' tidak ada atau tidak valid
            return response()->json(['error' => 'Tipe tidak ditemukan'], 400);
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
        
        return response()->json(['sisa_stok' => $obat->stok_obat]);
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
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan.');
        }

        $pengajuanBahan = PengajuanBahan::findOrFail($id);

        // Set status pengajuan menjadi true
        $pengajuanBahan->status = true;
        $pengajuanBahan->save();

        // Ambil semua data obat terkait dengan pengajuan bahan ini
        $obatPengajuanBahans = $pengajuanBahan->obatPengajuanBahans;

        // dd($obatPengajuanBahans);

        foreach ($obatPengajuanBahans as $obatPengajuanBahan) {
            if ($obatPengajuanBahan->tipe === 'obat') {
                // Menyimpan data ke stok_keluars
                StokKeluar::create([
                    'semester_id' => $semesterAktif->id,
                    'obat_id' => $obatPengajuanBahan->obat_id,
                    'jumlah_pemakaian' => $obatPengajuanBahan->jumlah_pemakaian,
                    'tanggal_keluar' => now(),
                ]);
    
                // Update stok pada tabel obats
                $obat = Obat::find($obatPengajuanBahan->obat_id);
                if ($obat) {
                    $obat->stok_obat -= $obatPengajuanBahan->jumlah_pemakaian;
                    $obat->save();
                }
            } else {
                BahanKeluar::create([
                    'semester_id' => $semesterAktif->id,
                    'bahan_id' => $obatPengajuanBahan->bahan_id,
                    'jumlah_pemakaian' => $obatPengajuanBahan->jumlah_pemakaian,
                    'tanggal_keluar' => now(),
                ]);
    
                // Update stok pada tabel obats
                $bahan = Bahan::find($obatPengajuanBahan->obat_id);
                if ($bahan) {
                    $bahan->stok_bahan -= $obatPengajuanBahan->jumlah_pemakaian;
                    $bahan->save();
                }
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
