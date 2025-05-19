<?php

namespace App\Http\Controllers;

use App\Application\Services\GetLabResultsForPatientService;
use App\Http\Resources\LabResultResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LabResultController extends Controller
{
    protected GetLabResultsForPatientService $getLabResultsService;

    public function __construct(GetLabResultsForPatientService $getLabResultsService)
    {
        $this->getLabResultsService = $getLabResultsService;
    }

    public function index(Request $request)
    {
        // TEMPORAIRE: Utiliser un ID patient codé en dur.
        // À remplacer par l'ID du patient authentifié via JWT.
        $patientId = 1; // $request->user()->id; ou une logique similaire
        Log::info("LabResultController: Fetching lab results for hardcoded user_patient_id {$patientId}");

        $labResultsDTOs = $this->getLabResultsService->execute($patientId);

        return LabResultResource::collection($labResultsDTOs);
    }
}