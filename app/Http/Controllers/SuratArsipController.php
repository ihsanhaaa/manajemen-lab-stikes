<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;

class SuratArsipController extends Controller
{
    public function index()
    {
        $surat_arsips = Surat::where('kategori_berkas', 'Surat Arsip')->get();

        return view('surat-masuks.suratArsip', compact('surat_arsips'));
    }
}
