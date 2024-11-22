<?php

namespace App\Http\Controllers;

use App\Imports\ObatImport;
use App\Imports\ObatMasukImport;
use App\Models\BentukSediaan;
use App\Models\Foto;
use App\Models\Kemasan;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\Semester;
use App\Models\StokMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StokMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stokMasuks = StokMasuk::all();
        $kemasans = Kemasan::all();
        $satuans = Satuan::all();
        $bentukSediaans = BentukSediaan::all();

        return view('stok-masuks.index', compact('stokMasuks', 'kemasans', 'satuans', 'bentukSediaans'));
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
        $validated = $request->validate([
            'obat_id' => 'required|exists:obats,id',
            'tanggal_masuk' => 'required|date',
        ]);

        // Buat catatan stok masuk
        StokMasuk::create($validated);

        // Perbarui stok obat
        $obat = Obat::find($request->obat_id);
        $obat->increment('stok_obat', $request->jumlah_masuk);

        return redirect()->route('stok_masuk.index')->with('success', 'Stok obat berhasil ditambah.');
    }

    public function importExcel(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'jumlah_masuk' => 'required|integer',
            'tanggal_masuk' => 'required|date',
        ]);

        Excel::import(new ObatMasukImport, $request->file('file'));

        return redirect()->back()->with('success', 'Data obat berhasil diimpor!');
    }

    public function importExcelBaru(Request $request)
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
        $importedData = array_slice($importedData, 1); // Skip baris 1-6, mulai dari baris ke-7

        // Ambil semester aktif
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan.');
        }

        foreach ($importedData as $row) {
            // dd($row);
            // Bersihkan nama barang dan cari alat$kemasan = Kemasan::firstOrCreate(['nama_kemasan' => $row[3]]);
            $satuan = Satuan::firstOrCreate(['nama_satuan' => $row[6]]);
            $bentuk_sediaan = BentukSediaan::firstOrCreate(['nama_bentuk_sediaan' => $row[4]]);

            // Cari obat berdasarkan kode_obat
            $obat = Obat::where('kode_obat', $row[0])->first();

            $expDate = null;

            if ($row[5]) {
                if (is_numeric($row[5])) {
                    $expDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]))->format('Y-m-d');
                } else {
                    $expDate = Carbon::createFromFormat('d/m/Y', $row[5])->format('Y-m-d');
                }
            }

            if ($obat) {
                // Update data obat jika sudah ada
                $obat->update([
                    'nama_obat' => $row[1] ?? null,
                    'kekuatan_obat' => $row[2] ?? null,
                    'kemasan_id' => $kemasan->id ?? null,
                    'bentuk_sediaan_id' => $bentuk_sediaan->id ?? null,
                    'exp_obat' => $expDate ?? now(),
                    'satuan_id' => $satuan->id ?? null,
                ]);

                // Perbarui stok obat dan hitung sisa obat
                $obat->update([
                    'sisa_obat' => $obat->stok_obat + ($row[7] ?? 0),

                    // 'harga_satuan' => $obat->stok_obat + ($row[7] ?? 0),
                    // 'total_harga' => $obat->stok_obat + ($row[7] ?? 0),
                ]);
            } else {
                // Jika belum ada, buat data obat baru
                $obat = Obat::create([
                    'kode_obat' => $row[0] ?? null,
                    'nama_obat' => $row[1] ?? null,
                    'kekuatan_obat' => $row[2] ?? null,
                    'kemasan_id' => $kemasan->id ?? null,
                    'bentuk_sediaan_id' => $bentuk_sediaan->id ?? null,
                    'exp_obat' => $expDate ?? now(),
                    'satuan_id' => $satuan->id ?? null,
                    'stok_obat' => $row[7] ?? 0,
                    'sisa_obat' => $row[7] ?? 0,
                ]);
            }

            $tanggalMasuk = null;

            if ($row[5]) {
                if (is_numeric($row[5])) {
                    $tanggalMasuk = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]))->format('Y-m-d');
                } else {
                    $tanggalMasuk = Carbon::createFromFormat('d/m/Y', $row[5])->format('Y-m-d');
                }
            }

            // Buat entri StokMasuk
            $stokMasuk = StokMasuk::create([
                'semester_id' => $semesterAktif->id,
                'obat_id' => $obat->id,
                'jumlah_masuk' => $row[7] ?? 0,
                'tanggal_masuk' => $tanggalMasuk ?? now(),

                'harga_satuan' => $row[8] ?? 0,
                'total_harga' => $row[7] * $row[8] ?? 0,
            ]);

            // Simpan foto wajib
            Foto::create([
                'stok_masuk_id' => $stokMasuk->id,
                'foto_path' => $fotoPath,
            ]);
        }

        return redirect()->back()->with('success', 'Data obat berhasil diimpor.');
    }

    public function BCimportExcelBaru(Request $request)
    {
        // Validasi request file dan foto
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
            'tanggal_masuk' => 'required|date',
            'foto_path.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:5048' // Validasi untuk setiap file foto
        ]);

        try {
            // Simpan nilai tambahan ke session
            session([
                'tanggal_masuk' => $request->tanggal_masuk,
            ]);

            // Periksa apakah file valid
            if ($request->hasFile('file')) {
                // Jalankan import data excel
                Excel::import(new ObatMasukImport, $request->file('file'));
            } else {
                // Mengembalikan error jika file tidak ada
                return redirect()->back()->with('error', 'File Excel tidak ditemukan.');
            }

            // Hapus session data setelah proses selesai
            session()->forget('tanggal_masuk');

            // Kembalikan respon sukses
            return redirect()->back()->with('success', 'Data obat berhasil diimpor!');
            
        } catch (\Exception $e) {
            // Tangani error jika terjadi kesalahan dalam proses import
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }




    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $obat = Obat::with(['kemasan', 'bentukSediaan', 'satuan'])->findOrFail($id);

        return view('stok-masuks.show', compact('obat'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StokMasuk $stokMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StokMasuk $stokMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StokMasuk $stokMasuk)
    {
        //
    }
}
