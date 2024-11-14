<?php

use App\Http\Controllers\ObatController;
use App\Http\Controllers\PengajuanBahanController;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\StokKeluarController;
use App\Http\Controllers\StokMasukController;
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


    Route::resource('/data-obat-masuk', StokMasukController::class);
    
    Route::resource('/data-obat-keluar', StokKeluarController::class);
    
    Route::resource('/pengajuan-bahan', PengajuanBahanController::class);

    Route::post('pengajuan-bahan/konfirmasi/{id}', [PengajuanBahanController::class, 'update'])
        ->name('pengajuan-bahan.konfirmasi.update');
    
    // Route::post('/data-obat/import', [StokMasukController::class, 'importExcel'])->name('data-obat.import');
    
    Route::post('/data-obat/import', [StokMasukController::class, 'importExcelBaru'])->name('data-obat.import');
    
    Route::get('/get-stok/{obatId}', function ($obatId) {
        $obat = Obat::find($obatId);
        if ($obat) {
            return response()->json(['stok_obat' => $obat->sisa_obat]);
        }
        return response()->json(['stok_obat' => 0]); // Jika obat tidak ditemukan, return 0 stok
    });

    // Route::get('/get-sisa-stok/{id}', [PengajuanBahanController::class, 'getSisaStok']);

    
});


// google
Route::get('oauth/google', [\App\Http\Controllers\OauthController::class, 'redirectToProvider'])->name('oauth.google');  
Route::get('oauth/google/callback', [\App\Http\Controllers\OauthController::class, 'handleProviderCallback'])->name('oauth.google.callback');

Auth::routes();


