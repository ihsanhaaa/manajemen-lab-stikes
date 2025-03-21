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
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StokMasukController extends Controller
{
    public function index()
    {
        $stokMasuks = StokMasuk::orderBy('tanggal_masuk', 'desc')->get();
        $kemasans = Kemasan::all();
        $satuans = Satuan::all();
        $bentukSediaans = BentukSediaan::all();

        $obats = Obat::orderBy('nama_obat', 'asc')->get();

        return view('stok-masuks.index', compact('stokMasuks', 'kemasans', 'satuans', 'bentukSediaans', 'obats'));
    }

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

    public function importExcelBaru(Request $request)
    {
        // Ambil semester aktif
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan.');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
            'foto_path' => 'required|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Upload file Excel
        $file = $request->file('file');
        $filePath = $file->store('import', 'public');

        // Upload Foto Bukti Transaksi
        $fotoFile = $request->file('foto_path');
        $path = 'foto-transaksi-obat-masuk/';
        $newName = 'foto-' . date('Ymd') . '-' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();

        // Pindahkan file ke folder public_path
        $fotoFile->move(public_path($path), $newName);

        // Simpan path foto
        $fotoPath = $path . $newName;

        // Load Excel and skip the first 6 rows (header + empty rows)
        $importedData = Excel::toArray([], $file)[0]; // Ambil sheet pertama
        $importedData = array_slice($importedData, 3); // Skip baris 1-6, mulai dari baris ke-7

        foreach ($importedData as $row) {
            // dd($row);
            $satuan = Satuan::firstOrCreate(['nama_satuan' => $row[6]]);
            $bentuk_sediaan = BentukSediaan::firstOrCreate(['nama_bentuk_sediaan' => $row[4]]);

            // Cari obat berdasarkan kode_obat
            $obat = Obat::where('kode_obat', $row[0])->first();

            $expDate = null;
            if (!empty($row[5])) {
                if (is_numeric($row[5])) {
                    $expDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]))->format('Y-m-d');
                } else {
                    try {
                        $expDate = Carbon::createFromFormat('d/m/Y', $row[5])->format('Y-m-d');
                    } catch (\Exception $e) {
                        // Handle error jika format tanggal salah
                        $expDate = null;
                    }
                }
            }

            if ($obat) {
                $obat->update([
                    'exp_obat' => $expDate,
                    'stok_obat' => $obat->stok_obat + ($row[7] + $row[8] - $row[9] ?? 0),
                ]);
            } else {
                $obat = Obat::create([
                    'kode_obat' => $row[0] ?? null,
                    'nama_obat' => $row[1] ?? null,
                    'kekuatan_obat' => $row[2] ?? null,
                    'kemasan_id' => $kemasan->id ?? null,
                    'bentuk_sediaan_id' => $bentuk_sediaan->id ?? null,
                    'exp_obat' => $expDate,
                    'satuan_id' => $satuan->id ?? null,
                    'stok_awal' => $row[7] ?? 0,
                    'stok_obat' => $row[7] + $row[8] - $row[9] ?? 0,
                ]);
            }

            if($row[8] != 0) {

                // Buat entri Stok Masuk
                $stokMasuk = StokMasuk::create([
                    'semester_id' => $semesterAktif->id,
                    'obat_id' => $obat->id,
                    'jumlah_masuk' => $row[8] ?? 0,
                    'tanggal_masuk' => now(),
                    'harga_satuan' => $row[11] ?? 0,
                    'total_harga' => $row[8] * $row[11] ?? 0,
                ]);

                // Simpan foto wajib
                Foto::create([
                    'stok_masuk_id' => $stokMasuk->id,
                    'foto_path' => $fotoPath,
                ]);
            }

            if($row[9] != 0) {
                // Buat entri Stok Keluar
                $stokKeluar = StokKeluar::create([
                    'semester_id' => $semesterAktif->id,
                    'obat_id' => $obat->id,
                    'jumlah_pemakaian' => $row[9] ?? 0,
                    'tanggal_keluar' => now(),
                ]);
            }
        }

        return redirect()->back()->with('success', 'Data obat masuk berhasil diimpor');
    }
    public function show($id)
    {
        $obat = Obat::with(['kemasan', 'bentukSediaan', 'satuan'])->findOrFail($id);

        return view('stok-masuks.show', compact('obat'));

    }

    public function updateTanggalMasuk(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
        ]);

        $stokMasuk = StokMasuk::findOrFail($id);
        $stokMasuk->tanggal_masuk = $request->tanggal_masuk;
        $stokMasuk->save();

        return response()->json(['success' => true, 'message' => 'Tanggal masuk berhasil diperbarui']);
    }

    public function storeObatMasukManual(Request $request)
    {
        // Mendapatkan semester aktif
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan');
        }

        // Validasi data input
        $validated = $request->validate([
            'obat_id' => 'required|exists:obats,id', // Pastikan obat_id ada di tabel obats
            'jumlah_masuk' => 'required|integer|min:1',
            'tanggal_masuk' => 'required|date',
            'harga_satuan' => 'nullable|integer|min:0',
            'exp_bahan' => 'nullable|date', // Tanggal expired bersifat opsional
        ]);

        // Hitung total harga
        $totalHarga = $request->jumlah_masuk * ($request->harga_satuan ?? 0);

        // Simpan data ke tabel stok_masuks
        StokMasuk::create([
            'semester_id' => $semesterAktif->id,
            'obat_id' => $validated['obat_id'],
            'jumlah_masuk' => $validated['jumlah_masuk'],
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'harga_satuan' => $request->harga_satuan ?? 0,
            'total_harga' => $totalHarga,
            'keterangan' => $request->keterangan ?? null,
        ]);

        // Update stok_obat dan exp_obat pada tabel obats
        $obat = Obat::find($validated['obat_id']);
        if ($obat) {
            // Tambahkan jumlah masuk ke stok_obat
            $obat->stok_obat += $validated['jumlah_masuk'];

            // Perbarui exp_obat jika tanggal expired diinput
            if ($request->filled('exp_bahan')) {
                $obat->exp_obat = $request->exp_bahan;
            }

            // Simpan perubahan pada tabel obats
            $obat->save();
        }

        // Redirect dengan pesan sukses
        return redirect()->route('data-obat-masuk.index')->with('success', 'Data obat masuk berhasil disimpan dan stok diperbarui');
    }

}
