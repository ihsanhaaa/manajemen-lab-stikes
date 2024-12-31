<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\AlatRusak;
use App\Models\FormPemakaianAlat;
use App\Models\PemakaianAlat;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemakaianAlatController extends Controller
{
    public function index()
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        $alats = Alat::orderBy('nama_barang', 'asc')->get();

        $pemakaianAlats = PemakaianAlat::where('status', false)
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();

        $pemakaianAlatSelesais = PemakaianAlat::where('status', true)
            ->orderBy('tanggal_pelaksanaan', 'desc')
            ->get();

        return view('pemakaian-alats.index', compact('alats', 'pemakaianAlats', 'semesterAktif', 'pemakaianAlatSelesais'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'anggota_kelompok' => 'required|string',
            'nim_kelompok' => 'required|string',
            'kelas' => 'required|string',
            'tanggal_praktikum' => 'required|date',
            'nama_praktikum' => 'required|string',
            'alat.*' => 'required|exists:alats,id', // Validasi untuk alat harus ada di tabel 'alats'
            'ukuran.*' => 'required|string', // Ukuran alat harus berupa string
            'jumlah.*' => 'required|integer|min:1', // Jumlah minimal adalah 1
            'kondisi_pinjam.*' => 'required|in:Baik,Pecah', // Validasi kondisi pinjam
            'kondisi_kembali.*' => 'required|in:Baik,Pecah', // Validasi kondisi kembali
            'jumlah_rusak.*' => [
                'required', 
                'integer',
                function ($attribute, $value, $fail) use ($request) {
                    // Ambil indeks jumlah rusak dari field
                    $index = explode('.', $attribute)[1];
                    $kondisi = $request->input("kondisi_kembali.$index");
    
                    // Validasi jumlah_rusak harus nol jika kondisi_kembali 'Baik'
                    if ($kondisi === 'Baik' && $value != 0) {
                        $fail("Jumlah Pecah pada baris ke-" . ($index + 1) . " harus 0 jika Kondisi Kembali adalah 'Baik'.");
                    }
    
                    // Validasi jumlah_rusak tidak boleh kosong jika kondisi_kembali 'Pecah'
                    if ($kondisi === 'Pecah' && $value <= 0) {
                        $fail("Jumlah Pecah pada baris ke-" . ($index + 1) . " harus lebih besar dari 0 jika Kondisi Kembali adalah 'Pecah'.");
                    }
                }
            ],
            'keterangan.*' => 'nullable|string', // Keterangan boleh kosong, tetapi jika diisi harus berupa string
        ]);

        DB::transaction(function () use ($request) {
            $semesterAktif = Semester::where('is_active', true)->first();

            if (!$semesterAktif) {
                return redirect()->back()->with('alert', 'Tidak ada semester yang aktif');
            }

            // Pisahkan nama dengan koma, format huruf kapital, dan gabungkan kembali
            $formattedNames = implode(', ', array_map(function ($name) {
                return ucwords(strtolower(trim($name))); // Format kapital untuk setiap nama
            }, explode(',', $request->anggota_kelompok)));
            
            $pemakaianAlat = PemakaianAlat::create([
                'semester_id' => $semesterAktif->id,
                'user_id' => auth()->id(),
                'nama_mahasiswa' => $formattedNames,
                'nim_kelompok' => $request->nim_kelompok,
                'kelas' => $request->kelas,
                'tanggal_pelaksanaan' => $request->tanggal_praktikum,
                'nama_praktikum' => $request->nama_praktikum,
            ]);

            foreach ($request->alat as $key => $alatId) {
                FormPemakaianAlat::create([
                    'pemakaian_alat_id' => $pemakaianAlat->id,
                    'user_id' => auth()->id(),
                    'alat_id' => $alatId,
                    'ukuran' => $request->ukuran[$key],
                    'jumlah' => $request->jumlah[$key],
                    'jumlah_rusak' => $request->jumlah_rusak[$key],
                    'kondisi_pinjam' => $request->kondisi_pinjam[$key],
                    'kondisi_kembali' => $request->kondisi_kembali[$key],
                    'keterangan' => $request->keterangan[$key] ?? null,
                ]);
            }
        });

        return redirect()->route('pemakaian-alat.index')->with('success', 'Data berhasil disimpan');
    }

    public function show($id)
    {
        $alats = Alat::all();

        $pemakaianAlat = PemakaianAlat::with('formPemakaianAlats')->findOrFail($id);

        return view('pemakaian-alats.show', compact('pemakaianAlat', 'alats'));

    }

    public function update($id)
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan');
        }

        $pemakaianAlat = PemakaianAlat::findOrFail($id);

        // Set status pengajuan menjadi true
        $pemakaianAlat->status = true;
        $pemakaianAlat->save();

        // Ambil semua data obat terkait dengan pengajuan bahan ini
        $formPemakaianAlats = $pemakaianAlat->formPemakaianAlats;

        // dd($formPemakaianAlats);

        foreach ($formPemakaianAlats as $formPemakaianAlat) {
            // dd($formPemakaianAlat);
            if ($formPemakaianAlat->kondisi_kembali === 'Pecah') {
                // Menyimpan data ke alat rusak
                AlatRusak::create([
                    'semester_id' => $semesterAktif->id,
                    'alat_id' => $formPemakaianAlat->alat_id,
                    'nama_perusak' => $pemakaianAlat->nama_mahasiswa,
                    'jumlah_rusak' => $formPemakaianAlat->jumlah_rusak,
                    'tanggal_rusak' => now(),
                ]);
    
                // Update stok pada tabel alats
                $alat = Alat::find($formPemakaianAlat->alat_id);
                if ($alat) {
                    $alat->stok -= $formPemakaianAlat->jumlah_rusak;
                    $alat->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Data Pemakaian Alat Sudah di ACC');
    }

    public function updateDetail(Request $request, $id)
    {
        $pemakaianAlat = PemakaianAlat::findOrFail($id);
        $pemakaianAlat->update($request->only(['nama_mahasiswa', 'nim_kelompok', 'kelas']));

        foreach ($request->alat as $index => $alatId) {
            $pemakaianAlat->formPemakaianAlats[$index]->update([
                'alat_id' => $alatId,
                'ukuran' => $request->ukuran[$index],
                'jumlah' => $request->jumlah[$index],
                'kondisi_pinjam' => $request->kondisi_pinjam[$index],
                'kondisi_kembali' => $request->kondisi_kembali[$index],
                'keterangan' => $request->keterangan[$index] ?? null,
            ]);
        }

        return redirect()->back()->with('success', 'Data berhasil diperbarui');
    }


    public function destroy($id)
    {
        // Cari data pemakaian_alats berdasarkan ID
        $pemakaianAlat = PemakaianAlat::findOrFail($id);

        // Hapus data yang terkait di tabel form_pemakaian_alats
        FormPemakaianAlat::where('pemakaian_alat_id', $pemakaianAlat->id)->delete();

        // Hapus data utama di tabel pemakaian_alats
        $pemakaianAlat->delete();

        // Redirect atau kembali dengan pesan sukses
        return redirect()->route('pemakaian-alat.index')
            ->with('success', 'Data Pemakaian Alat berhasil dihapus');
    }

    public function destroyPengajuanPeminjamanAlat($id)
    {
        $pemakaianAlat = FormPemakaianAlat::find($id);

        // dd($pemakaianAlat);

        $cekPemakaianAlat = PemakaianAlat::find($pemakaianAlat->pemakaian_alat_id);

        // dd($cekPengajuanBahan);

        if($cekPemakaianAlat->status == 0) {
            FormPemakaianAlat::find($id)->delete();
        } else {
            return redirect()->back()->with('error', 'Data Sudah di ACC, tidak bisa dihapus');
        }

        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
