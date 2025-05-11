<?php

namespace App\Http\Controllers;

use App\Application\Services\GetMedicalHistoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MedicalHistoryController extends Controller
{
    private GetMedicalHistoryService $service;

    public function __construct(GetMedicalHistoryService $service)
    {
        $this->service = $service;
    }

    public function show(Request $request, int $patientId): JsonResponse
    {
        $medicalHistory = $this->service->execute($patientId);

        if (!$medicalHistory) {
            return response()->json(['message' => 'Medical history not found'], 404);
        }

        return response()->json($medicalHistory, 200);
    }
}