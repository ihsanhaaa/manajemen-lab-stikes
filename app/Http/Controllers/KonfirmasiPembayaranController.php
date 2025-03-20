<?php

namespace App\Http\Controllers;

use App\Models\FotoBuktiBayar;
use App\Models\KonfirmasiPembayaran;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonfirmasiPembayaranController extends Controller
{
    public function index()
    {
        $buktiPembayarans = KonfirmasiPembayaran::all();

        return view('konfirmasi-pembayaran.index', compact('buktiPembayarans'));
    }

    public function store(Request $request)
    {
        $semesterAktif = Semester::where('is_active', true)->first();

        if (!$semesterAktif) {
            return redirect()->back()->with('error', 'Semester aktif tidak ditemukan');
        }

        // Validasi input
        $validated = $request->validate([
            'nama_mahasiswa' => 'nullable|string|max:255',
            'nim' => 'nullable|string|max:255',
            'jenis_pembayaran' => 'string|max:50',
            'tanggal' => 'required|date', // Pastikan format tanggal benar
            'bukti_bayar.*' => 'required|mimes:jpeg,png,jpg,pdf|max:2048',
        ]);

        // Update nama mahasiswa jika ada perubahan
        if ($request->has('nama_mahasiswa') && $request->nama_mahasiswa !== Auth::user()->name) {
            Auth::user()->update(['name' => $request->nama_mahasiswa]);
        }

        // Update nim jika ada perubahan
        if ($request->has('nim') && $request->nim !== Auth::user()->nim) {
            Auth::user()->update(['nim' => $request->nim]);
        }

        // Simpan data ke database
        $inhal = new KonfirmasiPembayaran();
        $inhal->user_id = Auth::id();
        $inhal->semester_id = $semesterAktif->id;
        $inhal->tanggal = $validated['tanggal'];
        $inhal->jenis_pembayaran = $validated['jenis_pembayaran'];
        $inhal->status = false; // Boolean value
        $inhal->save();

        if ($request->hasFile('bukti_bayar')) {
            foreach ($request->file('bukti_bayar') as $fotoFile) {
                $path = 'foto-bukti-bayar/';
                $newName = 'foto-' . date('Ymd') . '-' . uniqid() . '.' . $fotoFile->getClientOriginalExtension();
        
                // Pindahkan file ke folder public_path
                $fotoFile->move(public_path($path), $newName);
        
                // Simpan path file ke database
                FotoBuktiBayar::create([
                    'konfirmasi_pembayaran_id' => $inhal->id,
                    'foto_path' => $path . $newName,
                ]);
            }
        }        

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data Inhal berhasil disimpan');
    }


    public function updateStatus($id)
    {
        $inhal = KonfirmasiPembayaran::findOrFail($id);
        $inhal->update(['status' => true]);

        return redirect()->back()->with('success', 'Data inhal sudah di ACC');
    }
}
