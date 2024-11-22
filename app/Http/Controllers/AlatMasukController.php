<?php

namespace App\Http\Controllers;

use App\Imports\AlatMasukImport;
use App\Models\Alat;
use App\Models\AlatMasuk;
use App\Models\FotoAlatMasuk;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class AlatMasukController extends Controller
{
    public function index()
    {
        $alat_masuks = AlatMasuk::all();

        return view('alat-masuks.index', compact('alat_masuks'));
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
        $importedData = array_slice($importedData, 5); // Skip baris 1-6, mulai dari baris ke-7

        // Ambil semester aktif
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan.');
        }

        foreach ($importedData as $row) {
            // dd($row);

            if ($row[3] != 0) {
                // Bersihkan nama barang dan cari alat
                $namaBarang = ucwords(strtolower(trim($row[0]))); // Mengubah format menjadi kapital di awal
                $alat = Alat::where('nama_barang', $namaBarang)->first();

                if (!$alat) {
                    $alat = Alat::create([
                        'nama_barang' => $namaBarang,
                        'stok' => $row[1] ?? 0,
                        'ukuran' => $row[2] ?? null,
                        'penyimpanan' => $row[6] ?? null,
                        'letak_aset' => $row[7] ?? null,
                    ]);

                    $alat->update([
                        'stok' => $alat->stok + ($row[3] ?? 0),
                    ]);
                    
                } else {
                    $alat->update([
                        'stok' => $alat->stok + ($row[3] ?? 0),
                    ]);
                }

                // Buat catatan alat masuk
                $tanggalMasuk = null;

                if ($row[4]) {
                    if (is_numeric($row[4])) {
                        $tanggalMasuk = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]))->format('Y-m-d');
                    } else {
                        $tanggalMasuk = Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d');
                    }
                }

                $alatMasuk = AlatMasuk::create([
                    'semester_id' => $semesterAktif->id,
                    'alat_id' => $alat->id,
                    'jumlah_masuk' => $row[3] ?? 0,
                    'tanggal_masuk' => $tanggalMasuk ?? now(),
                    'harga_satuan' => $row[8] ?? 0,
                    'total_harga' => $row[5] * $row[8] ?? 0,
                ]);

                // Simpan foto wajib
                FotoAlatMasuk::create([
                    'alat_masuk_id' => $alatMasuk->id,
                    'foto_path' => $fotoPath,
                ]);
            }

        }

        return redirect()->back()->with('success', 'Data alat berhasil diimpor.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $alat = Alat::with(['kemasan', 'bentukSediaan', 'satuan'])->findOrFail($id);

        return view('alat-masuks.show', compact('obat'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlatMasuk $stokMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlatMasuk $stokMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlatMasuk $stokMasuk)
    {
        //
    }
}
