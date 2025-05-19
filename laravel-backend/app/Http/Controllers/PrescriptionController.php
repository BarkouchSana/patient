<?php

namespace App\Http\Controllers;

use App\Application\Services\GetPrescriptionsForPatientService;
use App\Http\Resources\PrescriptionResource;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; // Pour l'authentification future
use Illuminate\Support\Facades\Log;

class PrescriptionController extends Controller
{
    private GetPrescriptionsForPatientService $getPrescriptionsService;

    public function __construct(GetPrescriptionsForPatientService $getPrescriptionsService)
    {
        $this->getPrescriptionsService = $getPrescriptionsService;
        // $this->middleware('auth:api'); // À activer plus tard
    }

    public function index(Request $request)
    {
        // TEMPORAIRE: Utiliser user_id = 1 pour le patient
        $userPatientId = 1;
        Log::info("PrescriptionController: Fetching prescriptions for hardcoded user_patient_id {$userPatientId}");

        // TODO: Remplacer par l'ID de l'utilisateur authentifié
        /*
        if (!Auth::check()) {
             Log::warning("PrescriptionController: User not authenticated.");
             return response()->json(['message' => 'Unauthenticated.'], 401);
        }
        $userPatientId = Auth::id(); // Ou $request->user()->id;
        Log::info("PrescriptionController: Fetching prescriptions for authenticated user_patient_id {$userPatientId}");
        */

        try {
            $prescriptionDTOs = $this->getPrescriptionsService->execute($userPatientId);
            
            if ($prescriptionDTOs->isEmpty()) {
                Log::info("PrescriptionController: No prescriptions found for user_patient_id {$userPatientId}");
            }
            // Laravel enveloppe automatiquement les collections de ressources dans une clé "data"
            return PrescriptionResource::collection($prescriptionDTOs);

        } catch (\Exception $e) {
            Log::error("PrescriptionController: Error fetching prescriptions for user_patient_id {$userPatientId}: " . $e->getMessage(), ['exception' => $e]);
            return response()->json(['message' => 'An error occurred while fetching prescriptions.'], 500);
        }
    }
}