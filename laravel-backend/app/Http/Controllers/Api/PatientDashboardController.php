<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GetPatientDashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientDashboardController extends Controller
{
//     public function __construct(
//         private GetPatientDashboardService $svc
//     ) {}

//     /**
//      * GET /api/patient/dashboard?userId=...
//      */
//     public function show(Request $req): JsonResponse
//     {
//         // Validate userId query parameter
//         $userId = $req->query('userId');
//         if (!is_numeric($userId) || (int)$userId <= 0) {
//             return response()->json(['message' => 'Invalid userId parameter'], 400);
//         }

//         // Execute the service to fetch the dashboard data
//         try {
//             $dto = $this->svc->execute((int)$userId);

//             if (!$dto) {
//                 return response()->json(['message' => 'Patient not found'], 404);
//             }

//             return response()->json($dto, 200);
//         } catch (\Exception $e) {
//             // Log the error for debugging
//             Log::error('Error fetching patient dashboard', [
//                 'userId' => $userId,
//                 'error'  => $e->getMessage(),
//             ]);

//             return response()->json(['message' => 'An unexpected error occurred'], 500);
//         }
//     }
}