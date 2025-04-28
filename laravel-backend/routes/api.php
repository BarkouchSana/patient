<?php

use Illuminate\Support\Facades\Route;
use App\UI\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Ici on enregistre vos routes API. Elles seront
| chargées par le RouteServiceProvider avec le préfixe "api".
|
*/

// Route::middleware('jwt.auth')->group(function () {
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
// });
