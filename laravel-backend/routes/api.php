<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

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
    Route::get('profile', [ProfileController::class, 'getProfile'])->name('profile.show');
    Route::put('profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
    Route::post('profile/update-image', [ProfileController::class, 'updateProfileImage'])->name('profile.update-image');
// });
