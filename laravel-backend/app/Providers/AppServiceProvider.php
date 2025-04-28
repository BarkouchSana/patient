<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
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
             // Enregistrer les routes API
             Route::prefix('api')
             ->middleware('api')
             ->group(base_path('routes/api.php'));
 
         // Enregistrer les routes Web (déjà fait par défaut)
         Route::middleware('web')
             ->group(base_path('routes/web.php'));
    }
}
