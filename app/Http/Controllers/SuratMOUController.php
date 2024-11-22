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
            if ($surat->tanggal_mulai && $surat->tanggal_berakhir) {
                $tanggalMulai = Carbon::parse($surat->tanggal_mulai);
                $tanggalBerakhir = Carbon::parse($surat->tanggal_berakhir);
                $surat->selisih_hari = $tanggalMulai->diffInDays($tanggalBerakhir);
            } else {
                $surat->selisih_hari = null; // Jika tanggal tidak lengkap
            }
        }

        return view('surat-masuks.mou', compact('surat_mous'));
    }
}
