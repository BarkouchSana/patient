<?php

namespace App\Http\Controllers\Api;

use App\Services\GetLabResultsForPatientService;
use App\Http\Resources\LabResultResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\Patient;
class LabResultController extends Controller
{
    protected GetLabResultsForPatientService $getLabResultsService;

    public function __construct(GetLabResultsForPatientService $getLabResultsService)
    {
        $this->getLabResultsService = $getLabResultsService;
        Log::info("LabResultController initialized");
    }

    public function index(Request $request)
    {
// Récupérer le premier patient de la base de données
        $patient = Patient::first();
        
        if (!$patient) {
            Log::error("LabResultController@index: No patient found in database");
            return response()->json(['error' => 'No patient record found in the database.'], 404);
        }
        
        Log::info("LabResultController@index: Using first patient", [
            'patient_id' => $patient->id
        ]);
        
        try {
            $labResultsDTOs = $this->getLabResultsService->execute($patient->id);
            
            Log::info("LabResultController@index: Retrieved lab results", [
                'count' => $labResultsDTOs->count(),
                'patient_id' => $patient->id
            ]);
             return LabResultResource::collection($labResultsDTOs);
        } catch (\Exception $e) {
            Log::error("LabResultController@index: Exception while retrieving lab results", [
                'patient_id' => $patient->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json(['error' => 'An error occurred while retrieving lab results.'], 500);
        }

    }
}