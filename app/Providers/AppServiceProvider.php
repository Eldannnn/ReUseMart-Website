<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Organisasi;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        if ($this->app->environment('production') || request()->header('X-Forwarded-Proto') === 'https' || env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }

        View::composer('*', function ($view) {
            try {
                if (\Illuminate\Support\Facades\Schema::hasTable('organisasi')) {
                    $view->with('daftarOrganisasi', Organisasi::all());
                } else {
                    $view->with('daftarOrganisasi', collect());
                }
            } catch (\Throwable $e) {
                $view->with('daftarOrganisasi', collect());
            }
        });
        Paginator::useBootstrapFive();

        Route::prefix('api')
            ->middleware('api')
            ->group(base_path('routes/api.php'));

        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    }
}
