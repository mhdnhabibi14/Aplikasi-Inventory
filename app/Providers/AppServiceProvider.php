<?php

namespace App\Providers;

use App\Models\PengaturanApk;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('*', function ($view) {

            $pengaturanApk = PengaturanApk::first();

            $namaAplikasi = $pengaturanApk?->nama_aplikasi
                ?? 'Aplikasi Inventory';

            $view->with('namaAplikasi', $namaAplikasi);
        });
    }
}
