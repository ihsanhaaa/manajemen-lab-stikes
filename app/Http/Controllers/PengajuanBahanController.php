<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BahanKeluar;
use App\Models\Mahasiswa;
use App\Models\Obat;
use App\Models\ObatPengajuanBahan;
use App\Models\PengajuanBahan;
use App\Models\Satuan;
use App\Models\Semester;
use App\Models\StokKeluar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengajuanBahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        // dd($semesterAktif);

        $obats = Obat::with('stokKeluars')->get();
        $bahans = Bahan::with('bahanKeluars')->get();

        // $pengajuanbahans = PengajuanBahan::where('status', false)
        //     ->orderBy('tanggal_pelaksanaan', 'desc')
        //     ->get();
        $pengajuanbahans = PengajuanBahan::with('semester') // Eager load data semester
            ->where('status', false)
            ->whereHas('semester', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();

            // dd($pengajuanbahans);

        $satuans = Satuan::all();

        return view('pengajuan-bahans.index', compact('obats', 'bahans', 'satuans', 'pengajuanbahans', 'semesterAktif'));
    }

    public function indexSelesai()
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        $obats = Obat::with('stokKeluars')->get();
        $bahans = Bahan::with('bahanKeluars')->get();

        // $pengajuanbahanSelesais = PengajuanBahan::where('status', true)
        //     ->orderBy('tanggal_pelaksanaan', 'desc')
        //     ->get();
        $pengajuanbahanSelesais = PengajuanBahan::with('semester') // Eager load data semester
            ->where('status', true)
            ->whereHas('semester', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();

        $satuans = Satuan::all();

        return view('pengajuan-bahans.indexSelesai', compact('obats', 'bahans', 'satuans', 'semesterAktif', 'pengajuanbahanSelesais'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        $mahasiswas = Mahasiswa::all();

        // dd($mahasiswas);

        // dd($semesterAktif);

        $obats = Obat::with('stokKeluars')->get();
        $bahans = Bahan::with('bahanKeluars')->get();

        // $pengajuanbahans = PengajuanBahan::where('status', false)
        //     ->orderBy('tanggal_pelaksanaan', 'desc')
        //     ->get();
        $pengajuanbahans = PengajuanBahan::with('semester') // Eager load data semester
            ->where('status', false)
            ->whereHas('semester', function ($query) {
                $query->where('is_active', true);
            })
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();

            // dd($pengajuanbahans);

        $satuans = Satuan::all();

        return view('pengajuan-bahans.create', compact('obats', 'bahans', 'satuans', 'pengajuanbahans', 'semesterAktif'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('alert', 'Tidak ada semester yang aktif');
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
            'jumlah_pemakaian.*' => [
                'required',
                'numeric',
                'min:0',
                'regex:/^\d+(\.\d{1,4})?$/'
            ],
            'satuan.*' => 'required',
            'keterangan.*' => 'nullable|string',
        ]);   
        
        $formattedNames = implode(', ', array_map(function ($name) {
            return ucwords(strtolower(trim($name))); // Format kapital untuk setiap nama
        }, explode(',', $validatedData['anggota_kelompok'])));

        // Simpan data utama ke tabel pengajuan_bahans
        $pengajuanBahan = PengajuanBahan::create([
            'semester_id' => $semesterAktif->id,
            'user_id' => Auth::user()->id,
            'nama_mahasiswa' => $formattedNames,
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
                            'keterangan' => $validatedData['keterangan'][$index] ?? null,
                        ]);
                    }
                }
            }
        } else {
            // Tangani kasus ketika 'tipe' tidak ada atau tidak valid
            return response()->json(['error' => 'Tipe tidak ditemukan'], 400);
        }  
        
        return redirect()->route('pengajuan-bahan.index')->with('success', 'Pengajuan bahan berhasil disimpan');
        // return redirect()->back()->with('success', 'Pengajuan bahan berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pengajuanBahan = PengajuanBahan::with('obatPengajuanBahans')->findOrFail($id);

        $bahans = Bahan::all();

        $obats = Obat::all();

        return view('pengajuan-bahans.show', compact('pengajuanBahan', 'bahans', 'obats'));

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
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan');
        }

        $pengajuanBahan = PengajuanBahan::findOrFail($id);

        // Set status pengajuan menjadi true
        $pengajuanBahan->status = true;
        $pengajuanBahan->save();

        // Ambil semua data obat terkait dengan pengajuan bahan ini
        $obatPengajuanBahans = $pengajuanBahan->obatPengajuanBahans;

        // dd($obatPengajuanBahans);

        foreach ($obatPengajuanBahans as $obatPengajuanBahan) {
            // dd($obatPengajuanBahan);
            if ($obatPengajuanBahan->tipe === 'obat') {
                // Menyimpan data ke stok_keluars
                StokKeluar::create([
                    'semester_id' => $semesterAktif->id,
                    'obat_id' => $obatPengajuanBahan->obat_id,
                    'jumlah_pemakaian' => $obatPengajuanBahan->jumlah_pemakaian,
                    'tanggal_keluar' => now(),
                    'keterangan' => $pengajuanBahan->user->name,
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
                    'keterangan' => $pengajuanBahan->user->name,
                ]);
    
                // Update stok pada tabel obats
                $bahan = Bahan::find($obatPengajuanBahan->bahan_id);
                if ($bahan) {
                    $bahan->stok_bahan -= $obatPengajuanBahan->jumlah_pemakaian;
                    $bahan->save();
                }
            }
        }
        
        return redirect()->back()->with('success', 'Pengajuan bahan sudah di ACC');
    }

    public function updateDetail(Request $request, $id)
    {
        // dd($request);
        $validatedData = $request->validate([
            'nama_mahasiswa' => 'required|string',
            'kelompok' => 'required|string',
            'kelas' => 'required|string',
            'tanggal_pelaksanaan' => 'required|date',
            'nama_praktikum' => 'required|string',
            'obatPengajuanBahans.*.tipe' => 'required|in:bahan,obat',
            'obatPengajuanBahans.*.obat_bahan_id' => 'required',
            'obatPengajuanBahans.*.jumlah_pemakaian' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,4})?$/',
            'obatPengajuanBahans.*.satuan' => 'required|string',
            'obatPengajuanBahans.*.keterangan' => 'nullable|string',
        ]);
        
    
        DB::beginTransaction();
    
        try {
            // Update informasi utama pada PengajuanBahan
            $pengajuanBahan = PengajuanBahan::findOrFail($id);
            // dd($pengajuanBahan->obatPengajuanBahans);

            $pengajuanBahan->update([
                'nama_mahasiswa' => $validatedData['nama_mahasiswa'],
                'kelompok' => $validatedData['kelompok'],
                'kelas' => $validatedData['kelas'],
                'tanggal_pelaksanaan' => $validatedData['tanggal_pelaksanaan'],
                'nama_praktikum' => $validatedData['nama_praktikum'],
            ]);

            // dd($request->obatPengajuanBahans);
    
            // Loop untuk update atau create pada obatPengajuanBahan
            foreach ($request->obatPengajuanBahans as $item) {
                // Ambil data berdasarkan pengajuan_bahan_id dan tipe
                $obatPengajuanBahan = ObatPengajuanBahan::find($item['id']);

                // dd($obatPengajuanBahan);

                if ($obatPengajuanBahan) {
                    
                    $obatPengajuanBahan->update([
                        'jumlah_pemakaian' => $item['jumlah_pemakaian'],
                        'satuan' => $item['satuan'],
                        'tipe' => $item['tipe'],
                        'keterangan' => $item['keterangan'],
                        'bahan_id' => $item['tipe'] === 'bahan' ? $item['obat_bahan_id'] : null,
                        'obat_id' => $item['tipe'] === 'obat' ? $item['obat_bahan_id'] : null,
                    ]);
                } 
            }
    
            DB::commit();
    
            return redirect()->back()->with('success', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // PengajuanBahan::find($id)->delete();
        $pengajuanBahan = PengajuanBahan::findOrFail($id);

        ObatPengajuanBahan::where('pengajuan_bahan_id', $pengajuanBahan->id)->delete();

        $pengajuanBahan->delete();

        return redirect()->route('pengajuan-bahan.index')
            ->with('success', 'Data Pengajuan Bahan Berhasil dihapus');
    }

    public function destroyPengajuanObatBahan($id)
    {
        $pengajuaBahan = ObatPengajuanBahan::find($id);

        $cekPengajuanBahan = PengajuanBahan::find($pengajuaBahan->pengajuan_bahan_id);

        // dd($cekPengajuanBahan);

        if($cekPengajuanBahan->status == 0) {
            ObatPengajuanBahan::find($id)->delete();
        } else {
            return redirect()->back()->with('error', 'Data Sudah di ACC, tidak bisa dihapus');
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
