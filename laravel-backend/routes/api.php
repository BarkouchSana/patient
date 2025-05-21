<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\PatientDashboardController;
use App\Http\Controllers\API\MedicalHistoryController;
use App\Http\Controllers\API\AppointmentHistoryController;
use App\Http\Controllers\API\PrescriptionController;
use App\Http\Controllers\API\LabResultController;
use App\Http\Controllers\API\BillController; 
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
    // Route::get('/patients/{patientId}/appointments/history',[AppointmentHistoryController::class, 'index']);
    Route::get('/appointments/history', [AppointmentHistoryController::class, 'index']);
    // Routes pour les détails et l'annulation des rendez-vous
    Route::get('/appointments/{id}', [AppointmentHistoryController::class, 'show']);
    Route::post('/appointments/{id}/cancel', [AppointmentHistoryController::class, 'cancel']);
    
    Route::get('/prescriptions', [PrescriptionController::class, 'index'])->name('prescriptions.index');
    Route::get('/lab-results', [LabResultController::class, 'index'])->name('labresults.index');
    
    Route::get('/patients/{patientId}/bills', [BillController::class, 'index'])->name('patients.bills.index');
    Route::get('/bills/{billId}/pdf', [BillController::class, 'downloadPdf'])->name('bills.pdf.download');

    
    // });
