<?php

namespace App\Http\Controllers;

use App\Models\Bahan;
use App\Models\BahanKeluar;
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

        // Load Excel and skip the first 6 rows (header + empty rows)
        $importedData = Excel::toArray([], $file)[0]; // Ambil sheet pertama
        $importedData = array_slice($importedData, 3);

        // Upload Foto Bukti Transaksi
        $fotoFile = $request->file('foto_path');
        $path = 'foto-transaksi-bahan-masuk/';
        $newName = 'foto-' . date('Ymd') . '-' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();

        // Pindahkan file ke folder public_path
        $fotoFile->move(public_path($path), $newName);

        // Simpan path foto
        $fotoPath = $path . $newName;

        foreach ($importedData as $row) {
            // dd($row);

                // $bahan = Bahan::where('kode_bahan', $row[1])->first();

                // dd($row[2]);

                $namaBahan = ucwords(strtolower(trim(preg_replace('/\s+/', ' ', $row[2]))));
                $bahan = Bahan::where('nama_bahan', $namaBahan)->first();


                // dd($namaBahan);

                $expDate = null;
                if (!empty($row[4])) {
                    if (is_numeric($row[4])) {
                        $expDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]))->format('Y-m-d');
                    } else {
                        try {
                            $expDate = Carbon::createFromFormat('d/m/Y', $row[4])->format('Y-m-d');
                        } catch (\Exception $e) {
                            // Handle error jika format tanggal salah
                            $expDate = null;
                        }
                    }
                }

                if ($bahan) {
                    $bahan->update([
                        'stok_bahan' => $bahan->stok_bahan + ($row[8] ?? 0),
                    ]);
                } else {
                    $bahan = Bahan::create([
                        'kode_bahan' => $row[1] ?? 0,
                        'nama_bahan' => $row[2] ?? 0,
                        'formula' => $row[3] ?? null,
                        'exp_bahan' => $expDate,
                        'jenis_bahan' => $row[5] ?? null,
                        'satuan' => $row[6] ?? null,
                        'stok_awal' => $row[7] ?? null,
                        'stok_bahan' => $row[7] + $row[8] - $row[9] ?? null,
                    ]);
                }

                if($row[8] != 0) {

                    $bahan_masuk = BahanMasuk::create([
                        'semester_id' => $semesterAktif->id,
                        'bahan_id' => $bahan->id,
                        'jumlah_masuk' => $row[8] ?? 0,
                        'tanggal_masuk' => now(),
                        'harga_satuan' => $row[11] ?? 0,
                        'total_harga' => $row[8] * $row[11] ?? 0,
                    ]);

                    FotoBahanMasuk::create([
                        'bahan_masuk_id' => $bahan_masuk->id,
                        'foto_path' => $fotoPath,
                    ]);
                }

                if($row[9] != 0) {
                    $bahan_keluar = BahanKeluar::create([
                        'semester_id' => $semesterAktif->id,
                        'bahan_id' => $bahan->id,
                        'jumlah_pemakaian' => $row[9] ?? 0,
                        'tanggal_keluar' => now(),
                    ]);
                }

        }

        return redirect()->back()->with('success', 'Data bahan masuk berhasil diimpor');
    }

    public function updateTanggalMasuk(Request $request, $id)
    {
        $request->validate([
            'tanggal_masuk' => 'required|date',
        ]);

        $bahanMasuk = BahanMasuk::findOrFail($id);
        // dd($bahanMasuk);
        $bahanMasuk->tanggal_masuk = $request->tanggal_masuk;
        $bahanMasuk->save();

        return response()->json(['success' => true, 'message' => 'Tanggal masuk berhasil diperbarui']);
    }
}
