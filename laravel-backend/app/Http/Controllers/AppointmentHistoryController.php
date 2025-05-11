<?php namespace App\Http\Controllers;

 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Application\Services\GetAppointmentHistoryService; // Ensure this is the correct namespace
use Illuminate\Http\Request;
class AppointmentHistoryController extends Controller
{

    private GetAppointmentHistoryService $getAppointmentHistoryService;

    public function __construct(GetAppointmentHistoryService $getAppointmentHistoryService)
    {
        $this->getAppointmentHistoryService = $getAppointmentHistoryService;
    }

 

    // public function index(Request $request)
    // {
    //     $user = Auth::user();
    //     if (!$user || !$user->patient) {
    //         return response()->json(['error' => 'Patient not found or not authenticated.'], 404);
    //     }

    //     $patientId = $user->patient->id;
    //     $appointmentDTOs = $this->getAppointmentHistoryService->execute($patientId);

    //     return response()->json($appointmentDTOs);
    // }


    public function index(Request $request): JsonResponse
    {
        // Get patientId from query parameter
        $patientId = $request->query('patientId');

        // Validate patientId
        if (!$patientId || !is_numeric($patientId) || (int)$patientId <= 0) {
            return response()->json(['error' => 'Valid patientId query parameter is required.'], 400);
        }

        $patientId = (int)$patientId;
        $appointmentDTOs = $this->getAppointmentHistoryService->execute($patientId);

        if ($appointmentDTOs->isEmpty()) {
            // Optionally return 404 if no appointments found, or an empty array as per current logic
            // return response()->json(['message' => 'No appointment history found for this patient.'], 404);
        }

        return response()->json($appointmentDTOs);
    }

}
