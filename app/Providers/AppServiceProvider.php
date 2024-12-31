<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\PemakaianAlat;
use App\Models\PengajuanBahan;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::setLocale('id');

        view()->composer('*', function ($view) {
            $countPemakaianAlat = PemakaianAlat::where('status', 'false')->count();
            $view->with('countPemakaianAlat', $countPemakaianAlat);
        });

        view()->composer('*', function ($view) {
            $countPemakaianBahan = PengajuanBahan::where('status', 'false')->count();
            $view->with('countPemakaianBahan', $countPemakaianBahan);
        });

    }
}
