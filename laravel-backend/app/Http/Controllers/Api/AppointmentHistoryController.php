<?php 

namespace App\Http\Controllers\Api;

 
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\GetAppointmentHistoryService; // Ensure this is the correct namespace
use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\Appointment; // Assuming Appointment model is in App\Models
use Carbon\Carbon; // For date manipulation
use App\DTOs\AppointmentDTO; // Assuming AppointmentDTO is in App\DTOs

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

    public function show(int $id): JsonResponse
    {
        $appointment = Appointment::with(['doctor', 'timeSlot'])->find($id);
        
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
        
        // Format date as "Month DaySuffix, Year" e.g., "May 10th, 2023"
        $formattedDate = Carbon::parse($appointment->date)->format('F jS, Y');

        // Format time as "HH:MM - HH:MM"
        $formattedTime = 'N/A';
        if ($appointment->timeSlot) {
            $formattedTime = Carbon::parse($appointment->timeSlot->start_time)->format('H:i') .
                         ' - ' .
                         Carbon::parse($appointment->timeSlot->end_time)->format('H:i');
        }
        
        $statusDisplay = $appointment->status;
        if ($statusDisplay === 'pending_change') {
            $statusDisplay = 'Pending';
        } elseif ($statusDisplay === 'scheduled') {
            $statusDisplay = 'Confirmed';
        } else {
            $statusDisplay = ucfirst($statusDisplay);
        }

        $doctorName = $appointment->doctor ? $appointment->doctor->name : 'N/A';
        $doctorSpecialty = $appointment->doctor ? $appointment->doctor->specialty : 'General Medicine';

        // Créer un DTO enrichi
        $appointmentDTO = new AppointmentDTO(
            id: $appointment->id,
            date: $formattedDate,
            time: $formattedTime,
            reason: $appointment->reason,
            status: $statusDisplay,
            doctorName: $doctorName,
            doctorSpecialty: $doctorSpecialty,
            cancelReason: $appointment->cancel_reason,
            location: 'Medical Center, Room ' . rand(100, 999), // Exemple
            followUp: str_contains(strtolower($appointment->title), 'follow'),
            notes: ['Patient requested morning appointment', 'Bring previous test results']
        );
        
        return response()->json($appointmentDTO);
    }


    public function cancel(int $id, Request $request): JsonResponse
    {
        $appointment = Appointment::find($id);
        
        if (!$appointment) {
            return response()->json(['error' => 'Appointment not found'], 404);
        }
        
        // Vérifier si le rendez-vous peut être annulé
        if (in_array($appointment->status, ['completed', 'cancelled'])) {
            return response()->json(
                ['error' => 'Cannot cancel appointment with status: ' . $appointment->status], 
                400
            );
        }
        
        // Mise à jour du statut et de la raison d'annulation
        $appointment->status = 'cancelled';
        $appointment->cancel_reason = $request->input('reason', 'Cancelled by patient');
        $appointment->save();
        
        return response()->json(['message' => 'Appointment cancelled successfully']);
    }
}
