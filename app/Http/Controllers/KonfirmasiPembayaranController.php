<?php

namespace App\Http\Controllers;

use App\Models\KonfirmasiPembayaran;
use App\Models\Semester;
use Illuminate\Http\Request;

class KonfirmasiPembayaranController extends Controller
{
    public function index()
    {
        $buktiPembayarans = KonfirmasiPembayaran::all();

        return view('konfirmasi-pembayaran.index', compact('buktiPembayarans'));
    }

    public function activate($id)
    {
        // Set semua semester ke non-aktif
        Semester::query()->update(['is_active' => false]);

        // Aktifkan semester yang dipilih
        $semester = Semester::findOrFail($id);
        $semester->update(['is_active' => true]);

        return redirect()->route('semesters.index')->with('success', 'Semester berhasil diaktifkan.');
    }

    public function deactivate($id)
    {
        // Aktifkan semester yang dipilih
        $semester = Semester::findOrFail($id);
        $semester->update(['is_active' => false]);

        return redirect()->route('semesters.index')->with('success', 'Semester berhasil dinonaktifkan.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'semester' => 'required|string|max:50',
            'tahun_ajaran' => 'required|string|max:255',
        ]);
    
        $semester = new Semester();
        $semester->semester = $request->semester;
        $semester->tahun_ajaran = $request->tahun_ajaran;
        $semester->save();
    
        return redirect()->route('semesters.index')->with('success', 'Data Semester berhasil disimpan.');
    }
}
