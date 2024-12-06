<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;

class SuratPentingController extends Controller
{
    public function index()
    {
        $surat_pentings = Surat::where('kategori_berkas', 'Surat Penting')->get();

        return view('surat-masuks.suratPenting', compact('surat_pentings'));
    }
}
