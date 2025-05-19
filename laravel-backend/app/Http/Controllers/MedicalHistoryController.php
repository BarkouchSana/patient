<?php
 
namespace App\Http\Controllers;

use App\Application\Services\GetMedicalHistoryService;
use Illuminate\Http\Request; // JsonResponse n'est plus nécessaire ici si on retourne une Resource
use App\Http\Resources\MedicalHistoryResource; // Ajouté

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
    public function show(Request $request, int $patientId)
    {

                // TEMPORAIRE: Utiliser un ID de patient fixe jusqu'à ce que l'authentification soit prête.
        // Plus tard, vous pourrez obtenir l'ID du patient authentifié, par exemple :
        // $authenticatedPatientId = $request->user()->id; // Ou Auth::id(), selon votre configuration d'authentification
        // Ou vous pourrez utiliser le $patientId passé en paramètre si l'API est destinée à accéder à l'historique de n'importe quel patient (avec les permissions appropriées).
        
        $targetPatientId = 1; // <--- CODE EN DUR POUR LE PATIENT ID 1

        // Décommentez la ligne ci-dessous et commentez/supprimez la ligne $targetPatientId = 1;
        // pour utiliser l'ID de la route une fois que vous n'avez plus besoin de la valeur codée en dur.
        // $targetPatientId = $patientId;

        // Ou, pour utiliser l'ID de l'utilisateur authentifié (exemple) :
        // if (!Auth::check()) {
        //     return response()->json(['message' => 'Unauthenticated.'], 401);
        // }
        // $targetPatientId = Auth::id(); // Assurez-vous que Auth::id() retourne l'ID du patient

        $medicalHistoryDto = $this->service->execute($targetPatientId);

        if (!$medicalHistoryDto) {
            return response()->json(['message' => 'Medical history information not found for this patient.'], 404);
        }

        return new MedicalHistoryResource($medicalHistoryDto);
    }
}