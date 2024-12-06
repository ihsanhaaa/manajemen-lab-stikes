<?php

namespace App\Http\Controllers;

use App\Models\AlatMasuk;
use App\Models\BahanMasuk;
use App\Models\Obat;
use App\Models\PengajuanBahan;
use App\Models\Semester;
use App\Models\StokKeluar;
use App\Models\StokMasuk;
use App\Models\Surat;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

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

        $semesterAktif = Semester::where('is_active', true)->first();

        $obatMasuk = 0;
        $bahanMasuk = 0;
        $alatMasuk = 0;
        if ($semesterAktif) {
            $obatMasuk = StokMasuk::where('semester_id', $semesterAktif->id)->sum('total_harga');
            $bahanMasuk = BahanMasuk::where('semester_id', $semesterAktif->id)->sum('total_harga');
            $alatMasuk = AlatMasuk::where('semester_id', $semesterAktif->id)->sum('total_harga');
        }

        $totalObatMasuk = StokMasuk::sum('total_harga');
        $totalBahanMasuk = BahanMasuk::sum('total_harga');
        $totalAlatMasuk = AlatMasuk::sum('total_harga');

        $dataPengajuanBahanUser = PengajuanBahan::where('user_id', Auth::user()->id)->get();

        // dd($dataPengajuanBahanUser);

        $currentDate = Carbon::now();

        // Menghitung jumlah obat yang belum expired (lebih dari 1 minggu)
        $belumExpiredCount = Obat::where('exp_obat', '>', $currentDate->copy()->addWeek())->count();

        // Menghitung jumlah obat yang mendekati expired (kurang dari 1 minggu)
        $mendekatiExpiredCount = Obat::where('exp_obat', '>', $currentDate)
                                    ->where('exp_obat', '<=', $currentDate->copy()->addWeek())
                                    ->count();

        // Menghitung jumlah obat yang sudah expired (tanggal telah lewat)
        $expiredCount = Obat::where('exp_obat', '<', $currentDate)->count();


        // Membuat array nama bulan
        $months = collect(range(1, 12))->map(function ($month) {
            return Carbon::create()->month($month)->format('F');
        });

        // Mengambil jumlah stok masuk per bulan
        $stokMasuk = StokMasuk::selectRaw('MONTH(tanggal_masuk) as month, SUM(jumlah_masuk) as total')
            ->whereYear('tanggal_masuk', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Mengambil jumlah stok keluar per bulan
        $stokKeluar = StokKeluar::selectRaw('MONTH(tanggal_keluar) as month, SUM(jumlah_pemakaian) as total')
            ->whereYear('tanggal_keluar', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        // Mengisi data stok masuk dan keluar per bulan dengan default 0 jika tidak ada data
        $stokMasukData = [];
        $stokKeluarData = [];
        foreach (range(1, 12) as $month) {
            $stokMasukData[] = $stokMasuk[$month] ?? 0;
            $stokKeluarData[] = $stokKeluar[$month] ?? 0;
        }

        // surat
        $tahunSekarang = Carbon::now()->format('Y');

        $suratPerKategori = Surat::selectRaw('kategori_berkas, MONTH(tanggal_berkas) as bulan, COUNT(*) as jumlah')
                ->whereYear('tanggal_berkas', Carbon::now()->year) // Hanya data tahun ini
                ->groupBy('kategori_berkas', 'bulan')
                ->orderBy('bulan')
                ->get();

        // Inisialisasi array untuk setiap kategori berkas
        $kategoriList = ['Surat Masuk', 'Surat Keluar', 'Surat SK', 'Surat Penting', 'Surat MOU', 'Surat Arsip'];

        // Inisialisasi data surat per kategori dan per bulan (semua bulan diisi 0 sebagai default)
        $dataSurat = [];
        foreach ($kategoriList as $kategori) {
            $dataSurat[$kategori] = array_fill(1, 12, 0); // Mengisi tiap bulan (1-12) dengan 0
        }

        // Mengisi jumlah surat sesuai kategori dan bulan dari hasil query
        foreach ($suratPerKategori as $data) {
            $dataSurat[$data->kategori_berkas][$data->bulan] = $data->jumlah;
        }

        // Inisialisasi label bulan (nama bulan)
        $bulan = [];
        for ($i = 1; $i <= 12; $i++) {
            $bulan[$i] = Carbon::create()->month($i)->format('F'); // Nama bulan
        }

        return view('home', compact('dataPengajuanBahan', 'obats', 'dataPengajuanBahanbelumAcc', 'dataPengajuanBahanUser',
                                                'belumExpiredCount', 'mendekatiExpiredCount', 'months', 'expiredCount', 'stokMasukData', 'stokKeluarData',
                                                 'bulan', 'dataSurat', 'tahunSekarang', 'obatMasuk', 'bahanMasuk', 'alatMasuk', 'semesterAktif',
                                                'totalObatMasuk', 'totalBahanMasuk', 'totalAlatMasuk'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data user
        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }

    public function showByMonth($bulan)
    {
        // Ubah nama bulan ke angka bulan
        $monthNumber = Carbon::parse($bulan)->month; 

        // Ambil data surat berdasarkan bulan
        $surat = Surat::whereMonth('tanggal_berkas', $monthNumber)
                    ->whereYear('tanggal_berkas', Carbon::now()->year)
                    ->get();

        return view('suratBulan', compact('surat', 'bulan'));
    }

}
