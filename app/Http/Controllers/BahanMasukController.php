<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BahanMasuk;
use App\Models\FotoBahanMasuk;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BahanMasukController extends Controller
{
    public function index()
    {
        $bahan_masuks = BahanMasuk::all();

        return view('bahan-masuks.index', compact('bahan_masuks'));
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
            'file' => 'required|file|mimes:xlsx,xls',
            'foto_path' => 'required|file|mimes:jpg,jpeg,png|max:2048', // Foto wajib
        ]);

        // Upload file Excel
        $file = $request->file('file');
        $filePath = $file->store('import', 'public');

        // Upload Foto Bukti Transaksi
        $fotoFile = $request->file('foto_path');
        $path = 'foto-bukti-transaksi/';
        $newName = 'foto-' . date('Ymd') . '-' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();

        // Pindahkan file ke folder public_path
        $fotoFile->move(public_path($path), $newName);

        // Simpan path foto
        $fotoPath = $path . $newName;

        // Load Excel and skip the first 6 rows (header + empty rows)
        $importedData = Excel::toArray([], $file)[0]; // Ambil sheet pertama
        $importedData = array_slice($importedData, 4); // Skip baris 1-6, mulai dari baris ke-7

        // Ambil semester aktif
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan.');
        }

        foreach ($importedData as $row) {
            // dd($row);

            if ($row[8] != 0) {
                $bahan = Bahan::where('kode_bahan', $row[1])->first();

                $expDate = null;
                if ($row[4]) {
                    if (is_numeric($row[4])) {
                        $expDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]))->format('Y-m-d');
                    } else {
                        $expDate = Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d');
                    }
                }

                if (!$bahan) {
                    $bahan = Bahan::create([
                        'kode_bahan' => $row[1] ?? 0,
                        'nama_bahan' => $row[2] ?? 0,
                        'formula' => $row[3] ?? null,
                        'exp_bahan' => $expDate ?? now(),
                        'jenis_bahan' => $row[5] ?? null,
                        'satuan' => $row[6] ?? null,
                    ]);

                    $bahan->update([
                        'stok_bahan' => $bahan->stok_bahan + ($row[8] ?? 0),
                    ]);
                    
                } else {
                    $bahan->update([
                        'stok_bahan' => $bahan->stok_bahan + ($row[8] ?? 0),
                    ]);
                }

                // Buat catatan alat masuk
                // $tanggalMasuk = null;

                // if ($row[4]) {
                //     if (is_numeric($row[4])) {
                //         $tanggalMasuk = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]))->format('Y-m-d');
                //     } else {
                //         $tanggalMasuk = Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d');
                //     }
                // }

                $bahan_masuk = BahanMasuk::create([
                    'semester_id' => $semesterAktif->id,
                    'bahan_id' => $bahan->id,
                    'jumlah_masuk' => $row[8] ?? 0,
                    'tanggal_masuk' => now(),
                    'harga_satuan' => $row[11] ?? 0,
                    'total_harga' => $row[8] * $row[11] ?? 0,
                ]);
                
                // dd($bahan_masuk);

                FotoBahanMasuk::create([
                    'bahan_masuk_id' => $bahan_masuk->id,
                    'foto_path' => $fotoPath,
                ]);
            }

        }

        return redirect()->back()->with('success', 'Data bahan berhasil ditambahkan.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $bahan = Bahan::with(['kemasan', 'bentukSediaan', 'satuan'])->findOrFail($id);

        return view('alat-masuks.show', compact('obat'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BahanMasuk $bahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BahanMasuk $bahan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BahanMasuk $bahan)
    {
        //
    }
}
