<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SuratMOUController extends Controller
{
    public function index()
    {
        $surat_mous = Surat::where('kategori_berkas', 'Surat MOU')->get();

        foreach ($surat_mous as $surat) {
            if ($surat->tanggal_berakhir) {
                $tanggalBerakhir = Carbon::parse($surat->tanggal_berakhir);
                $surat->selisih_hari = Carbon::now()->diffInDays($tanggalBerakhir, false); // Hitung selisih hari dari hari ini
            } else {
                $surat->selisih_hari = null; // Jika tanggal berakhir tidak tersedia
            }
        }

        return view('surat-masuks.mou', compact('surat_mous'));
    }
}
