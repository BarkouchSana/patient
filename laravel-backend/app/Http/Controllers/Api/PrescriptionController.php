<?php

namespace App\Http\Controllers\Api;

use App\Services\GetPrescriptionsForPatientService;
use App\Http\Resources\PrescriptionResource;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // Pour l'authentification future
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Patient; // Assurez-vous d'importer le modèle Patient
class PrescriptionController extends Controller
{
    private GetPrescriptionsForPatientService $getPrescriptionsService;

    public function __construct(GetPrescriptionsForPatientService $getPrescriptionsService)
    {
        $this->getPrescriptionsService = $getPrescriptionsService;
       Log::info("PrescriptionController initialized");
    }

    public function index(Request $request)
    {
        Log::info("PrescriptionController@index: Starting to fetch prescriptions");
        
        // Récupérer le premier patient de la base de données
        $patient = Patient::first();
        
        if (!$patient) {
            Log::error("PrescriptionController@index: No patient found in database");
            return response()->json(['error' => 'No patient record found in the database.'], 404);
        }
        
        Log::info("PrescriptionController@index: Using first patient", [
            'patient_id' => $patient->id
        ]);
        
        try {
            $prescriptionDTOs = $this->getPrescriptionsService->execute($patient->id);
            
            Log::info("PrescriptionController@index: Retrieved prescriptions", [
                'count' => $prescriptionDTOs->count(),
                'patient_id' => $patient->id
            ]);

            if ($prescriptionDTOs->isEmpty()) {
                Log::info("PrescriptionController@index: No prescriptions found for patient", [
                    'patient_id' => $patient->id
                ]);
                // Retourner une collection vide plutôt qu'une erreur 404
            }
            
            return PrescriptionResource::collection($prescriptionDTOs);

        } catch (\Exception $e) {
            Log::error("PrescriptionController@index: Exception while retrieving prescriptions", [
                'patient_id' => $patient->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'An error occurred while retrieving prescriptions.'], 500);
        }
    }
}