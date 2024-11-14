<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\PengajuanBahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dataPengajuanBahan = PengajuanBahan::all();
        $dataPengajuanBahanbelumAcc = PengajuanBahan::where('status', 0)->get();
        $obats = Obat::all();

        $dataPengajuanBahanUser = PengajuanBahan::where('user_id', Auth::user()->id)->get();

        // dd($dataPengajuanBahanUser);

        return view('home', compact('dataPengajuanBahan', 'obats', 'dataPengajuanBahanbelumAcc', 'dataPengajuanBahanUser'));
    }
}
