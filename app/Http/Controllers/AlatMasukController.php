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
        $alat_masuks = AlatMasuk::orderBy('tanggal_masuk', 'desc')->get();

        $alats = Alat::orderBy('nama_barang', 'asc')->get();

        return view('alat-masuks.index', compact('alat_masuks', 'alats'));
    }

    public function store(Request $request)
    {
        // Ambil semester aktif
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'foto_path' => 'required|file|mimes:jpg,jpeg,png|max:2048', // Foto wajib
        ]);

        // Upload file Excel
        $file = $request->file('file');
        $filePath = $file->store('import', 'public');

        // Upload Foto Bukti Transaksi
        $fotoFile = $request->file('foto_path');
        $path = 'foto-transaksi-alat-masuk/';
        $newName = 'foto-' . date('Ymd') . '-' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();

        // Pindahkan file ke folder public_path
        $fotoFile->move(public_path($path), $newName);

        // Simpan path foto
        $fotoPath = $path . $newName;

        // Load Excel and skip the first 6 rows (header + empty rows)
        $importedData = Excel::toArray([], $file)[0]; // Ambil sheet pertama
        $importedData = array_slice($importedData, 4); // Skip baris 1-6, mulai dari baris ke-7

        foreach ($importedData as $row) {
            // dd($row);

            // Bersihkan nama barang dan cari alat
            $namaBarang = ucwords(strtolower(trim($row[0]))); // Mengubah format menjadi kapital di awal
            $alat = Alat::where('nama_barang', $namaBarang)->first();
        
            $stokMasuk = is_numeric($row[3]) ? (int)$row[3] : 0; // Konversi ke integer jika valid

            if ($alat) {
                $alat->update([
                    'stok' => $alat->stok + $stokMasuk,
                ]);
            } else {
                $alat = Alat::create([
                    'nama_barang' => $namaBarang,
                    'stok_awal' => $row[1] ?? 0,
                    'stok' => $row[1] + $row[3] ?? 0,
                    'ukuran' => $row[2] ?? null,
                    'penyimpanan' => $row[6] ?? null,
                    'letak_aset' => $row[7] ?? null,
                ]);
            }
        
            if($row[3] != 0) {
                // Buat catatan alat masuk
                $tanggalMasuk = null;
            
                if ($row[4]) {
                    if (is_numeric($row[4])) {
                        $tanggalMasuk = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]))->format('Y-m-d');
                    } else {
                        $tanggalMasuk = Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d');
                    }
                }
            
                $hargaSatuan = is_numeric($row[8]) ? (float)$row[8] : 0; // Konversi ke float jika valid
                $totalHarga = is_numeric($row[5]) && is_numeric($row[8]) ? $row[5] * $hargaSatuan : 0; // Pastikan validasi
            
                $alatMasuk = AlatMasuk::create([
                    'semester_id' => $semesterAktif->id,
                    'alat_id' => $alat->id,
                    'jumlah_masuk' => $stokMasuk,
                    'tanggal_masuk' => $tanggalMasuk ?? now(),
                    'harga_satuan' => $hargaSatuan,
                    'total_harga' => $totalHarga,
                ]);
            
                // Simpan foto wajib
                FotoAlatMasuk::create([
                    'alat_masuk_id' => $alatMasuk->id,
                    'foto_path' => $fotoPath,
                ]);
            }          

        }

        return redirect()->back()->with('success', 'Data alat masuk berhasil diimpor');
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

    public function updateTanggalMasuk(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
        ]);

        $alatMasuk = AlatMasuk::findOrFail($id);
        $alatMasuk->tanggal_masuk = $request->tanggal_masuk;
        $alatMasuk->save();

        return response()->json(['success' => true, 'message' => 'Tanggal masuk berhasil diperbarui']);
    }

    public function storeAlatMasukManual(Request $request)
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan');
        }
        // Validasi data
        $validated = $request->validate([
            'alat_id' => 'required|exists:alats,id',
            'jumlah_masuk' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'harga_satuan' => 'nullable|integer|min:0',
        ]);

        // Hitung total harga
        $totalHarga = $request->jumlah_masuk * $request->harga_satuan;

        // Simpan data ke tabel bahan_masuks
        AlatMasuk::create([
            'semester_id' => $semesterAktif->id,
            'alat_id' => $validated['alat_id'],
            'jumlah_masuk' => $validated['jumlah_masuk'],
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'harga_satuan' => $validated['harga_satuan'] ?? 0,
            'total_harga' => $totalHarga,
        ]);

        // Redirect atau response
        return redirect()->route('data-alat-masuk.index')->with('success', 'Data alat masuk berhasil disimpan');
    }
}
