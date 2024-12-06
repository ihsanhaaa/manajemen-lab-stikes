<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{
    public function index()
    {
        $surat_keluars = Surat::where('kategori_berkas', 'Surat Keluar')->get();

        return view('surat-masuks.suratKeluar', compact('surat_keluars'));
    }
}
