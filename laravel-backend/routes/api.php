<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PatientDashboardController;
use App\Http\Controllers\MedicalHistoryController;
use App\Http\Controllers\AppointmentHistoryController;
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
    Route::get('patient/dashboard', [PatientDashboardController::class, 'show'])->name('patient.dashboard.show');
 

    
    Route::get('/patients/{patientId}/medical-history', [MedicalHistoryController::class, 'show']);
    Route::get('/patients/{patientId}/appointments/history',[AppointmentHistoryController::class, 'index']);
    Route::get('/appointments/history', [AppointmentHistoryController::class, 'index']);
    // });
