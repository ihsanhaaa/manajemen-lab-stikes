<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\SuratSK;
use Illuminate\Http\Request;

class SuratSKController extends Controller
{
    public function index()
    {
        $surat_sks = Surat::where('kategori_berkas', 'Surat SK')->get();

        return view('surat-masuks.suratSk', compact('surat_sks'));
    }
}
