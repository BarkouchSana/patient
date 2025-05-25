<?php
 
 namespace App\Http\Controllers\Api;

use App\Services\GetMedicalHistoryService;
use Illuminate\Http\Request; // JsonResponse n'est plus nécessaire ici si on retourne une Resource
use App\Http\Resources\MedicalHistoryResource; // Ajouté
use App\Http\Controllers\Controller; // Assurez-vous d'importer le bon namespace pour le contrôleur
use App\Models\Patient; // Assurez-vous d'importer le modèle Patient
class MedicalHistoryController extends Controller
{
    private GetMedicalHistoryService $service;

    public function __construct(GetMedicalHistoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @param Request $request
     * @param int $patientId L'ID de la table 'patients'
     * @return MedicalHistoryResource|\Illuminate\Http\JsonResponse
     */
    public function show(Request $request)
    {
          // Récupérer le premier patient de la table patients
        $patient = Patient::first();
        
        if (!$patient) {
            return response()->json(['message' => 'No patient found in the database.'], 404);
        }

       $targetPatientId = $patient->id;
        
        $medicalHistoryDto = $this->service->execute($targetPatientId);

        if (!$medicalHistoryDto) {
            return response()->json(['message' => 'Medical history information not found for this patient.'], 404);
        }

        return new MedicalHistoryResource($medicalHistoryDto);
    }
    }
