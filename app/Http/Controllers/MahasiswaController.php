<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    public function validateNIM(Request $request)
    {
        $request->validate([
            'nim' => 'required|string',
        ]);
    
        $nim = $request->input('nim');
        $mahasiswa = Mahasiswa::where('nim', $nim)->first();
    
        if (!$mahasiswa) {
            return back()->withErrors(['nim' => 'NIM anda tidak terdaftar.']);
        }
    
        // Cek apakah mahasiswa_id sudah digunakan oleh akun lain
        $existingUser = User::where('mahasiswa_id', $mahasiswa->id)->first();
        if ($existingUser && $existingUser->id !== auth()->id()) {
            return back()->withErrors(['nim' => 'NIM ini sudah terhubung dengan akun lain.']);
        }
    
        // Simpan mahasiswa_id ke akun user saat ini
        $user = auth()->user();
        $user->update(['mahasiswa_id' => $mahasiswa->id]);

        return redirect()->route('home')->with('success', 'NIM terdaftar, berhasil melakukan verifikasi!');
    }
}
