<?php

use App\Http\Controllers\AlatController;
use App\Http\Controllers\AlatMasukController;
use App\Http\Controllers\AlatRusakController;
use App\Http\Controllers\BahanController;
use App\Http\Controllers\BahanKeluarController;
use App\Http\Controllers\BahanMasukController;
use App\Http\Controllers\BentukSediaanController;
use App\Http\Controllers\KemasanController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PengajuanBahanController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\SemesterController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\StokMasukController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SuratMOUController;
use App\Models\Alat;
use App\Models\Bahan;
use App\Models\BentukSediaan;
use App\Models\PengajuanBahan;
use Illuminate\Support\Facades\Route;

use App\Models\Obat;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth']], function () {

    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::resource('/data-obat', ObatController::class);

    Route::resource('/data-bahan', BahanController::class);

    Route::resource('/data-bahan-masuk', BahanMasukController::class);

    Route::resource('/data-bahan-keluar', BahanKeluarController::class);

    Route::resource('/data-surat-masuk', SuratController::class);

    Route::get('/data-surat-mou', [SuratMOUController::class, 'index'])->name('data-surat-mou.index');

    Route::get('/obats/{status}', [ObatController::class, 'filterByStatus'])->name('obats.filter');

    Route::get('/laporan/obat/export-pdf', [ObatController::class, 'exportPDF'])->name('laporan.obat.exportPDF');

    Route::get('/laporan/bahan/export-pdf', [BahanController::class, 'exportPDF'])->name('laporan.bahan.exportPDF');

    Route::get('/laporan/alat/export-pdf', [AlatController::class, 'exportPDF'])->name('laporan.alat.exportPDF');

    Route::post('/obat/{id}/upload-fotos', [ObatController::class, 'uploadPhotoDetail'])->name('data-obat.uploadFoto');

    Route::post('/bahan/{id}/upload-fotos', [BahanController::class, 'uploadPhotoDetail'])->name('data-bahan.uploadFoto');

    Route::delete('/data-obat/hapus-foto/{id}', [ObatController::class, 'deletePhoto'])->name('data-obat.deleteFoto');

    Route::post('/alat/{id}/upload-fotos', [AlatController::class, 'uploadPhotoDetail'])->name('data-alat.uploadFoto');

    Route::delete('/data-alat/hapus-foto/{id}', [AlatController::class, 'deletePhoto'])->name('data-alat.deleteFoto');


    Route::resource('/data-obat-masuk', StokMasukController::class);

    Route::resource('/data-alat-masuk', AlatMasukController::class);

    Route::resource('/data-alat-rusak', AlatRusakController::class);
    
    Route::resource('/data-obat-keluar', StokKeluarController::class);
    
    Route::resource('/pengajuan-bahan', PengajuanBahanController::class);

    Route::resource('/data-kemasan', KemasanController::class);

    Route::resource('/data-bentuk-sediaan', BentukSediaanController::class);

    Route::resource('/data-satuan', SatuanController::class);

    Route::resource('/data-alat', AlatController::class);

    Route::post('pengajuan-bahan/konfirmasi/{id}', [PengajuanBahanController::class, 'update'])
        ->name('pengajuan-bahan.konfirmasi.update');
    
    // Route::post('/data-obat/import', [StokMasukController::class, 'importExcel'])->name('data-obat.import');
    
    Route::post('/data-obat/import', [StokMasukController::class, 'importExcelBaru'])->name('data-obat.import');
    
    Route::get('/get-stok/{obatId}', function ($obatId) {
        $obat = Obat::find($obatId);
        if ($obat) {
            return response()->json(['stok_obat' => $obat->stok_obat]);
        }
        return response()->json(['stok_obat' => 0]); // Jika obat tidak ditemukan, return 0 stok
    });

    Route::get('/get-stok-alat/{alatId}', function ($alatId) {
        $alat = Alat::find($alatId);
        if ($alat) {
            return response()->json(['stok' => $alat->stok]);
        }
        return response()->json(['stok' => 0]); // Jika obat tidak ditemukan, return 0 stok
    });

    Route::get('/get-stok-bahan/{bahanId}', function ($bahanId) {
        $bahan = Bahan::find($bahanId);
        if ($bahan) {
            return response()->json(['stok_bahan' => $bahan->stok_bahan]);
        }
        return response()->json(['stok_bahan' => 0]);
    });

    // Route::get('/get-sisa-stok/{id}', [PengajuanBahanController::class, 'getSisaStok']);

    Route::get('semesters', [SemesterController::class, 'index'])->name('semesters.index');
    Route::post('semesters/store', [SemesterController::class, 'store'])->name('semesters.store');
    Route::post('semesters/{id}/activate', [SemesterController::class, 'activate'])->name('semesters.activate');
    Route::post('semesters/{id}/deactivate', [SemesterController::class, 'deactivate'])->name('semesters.deactivate');

    
});


// google
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');  
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');

Auth::routes();


