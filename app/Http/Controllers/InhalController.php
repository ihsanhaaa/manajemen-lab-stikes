<?php

namespace App\Http\Controllers;

use App\Models\Inhal;
use App\Models\Semester;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InhalController extends Controller
{
    public function index()
    {
        $inhals = Inhal::all();

        return view('inhals.index', compact('inhals'));
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
            'nama_praktikum' => 'nullable|string|max:255',
            'percobaan' => 'nullable|string|max:255',
            'tanggal' => 'required|date', // Pastikan format tanggal benar
            'bukti_bayar' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        // Update nama mahasiswa jika ada perubahan
        if ($request->has('nama_mahasiswa') && $request->nama_mahasiswa !== Auth::user()->name) {
            Auth::user()->update(['name' => $request->nama_mahasiswa]);
        }

        // Update nim jika ada perubahan
        if ($request->has('nim') && $request->nim !== Auth::user()->nim) {
            Auth::user()->update(['nim' => $request->nim]);
        }

        // Lokasi folder untuk menyimpan file
        $path = 'foto-bukti-transaksi-inhal/';
        
        // Membuat nama file baru
        $new_name = 'inhal-' . Auth::id() . '-' . date('Ymd') . '-' . uniqid() . '.' . $request->file('bukti_bayar')->getClientOriginalExtension();
        
        // Memindahkan file ke folder tujuan
        $request->file('bukti_bayar')->move(public_path($path), $new_name);

        // Simpan data ke database
        $inhal = new Inhal();
        $inhal->user_id = Auth::id();
        $inhal->semester_id = $semesterAktif->id;
        $inhal->nama_praktikum = $validated['nama_praktikum'];
        $inhal->percobaan = $validated['percobaan'];
        $inhal->tanggal = $validated['tanggal']; // Format tanggal sudah valid
        $inhal->bukti_bayar = $path . $new_name;
        $inhal->status = false; // Boolean value
        $inhal->save();

        // Redirect dengan pesan sukses
        return redirect()->back()->with('success', 'Data Inhal berhasil disimpan.');
    }

    public function updateStatus($id)
    {
        $inhal = Inhal::findOrFail($id);
        $inhal->update(['status' => true]);

        return redirect()->back()->with('success', 'Data inhal sudah di ACC');
    }
}
