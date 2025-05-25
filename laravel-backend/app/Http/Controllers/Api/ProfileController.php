<?php

namespace App\Http\Controllers\APi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use App\Models\Patient;
use App\Models\PersonalInfo;
use App\Http\Controllers\Controller;
use App\Services\ChangePasswordService; // Assuming ChangePasswordService is in App\Services
use App\DTOs\ChangePasswordDTO; // Assuming ChangePasswordDTO is in App\DTOs
class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfile(Request $request)
    {
        $patient = Patient::first();
        
        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }
        
        $user = $patient->user;
            if (!$user) {
        return response()->json([
            'status' => 'error',
            'message' => 'User not found for this patient'
        ], 404);
    }
    
        // Get or create personal info record
        $personalInfo = PersonalInfo::firstOrCreate(['patient_id' => $patient->id]);
        
        $validator = Validator::make($request->all(), [
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->id,
            'name' => 'sometimes|string|max:255',
            'surname' => 'sometimes|string|max:255',
            'birthdate' => 'sometimes|date',
            'gender' => 'sometimes|string|max:50',
            'address' => 'sometimes|string',
            'emergencyContact' => 'sometimes|string',
            'maritalStatus' => 'sometimes|string|max:50',
            'bloodType' => 'sometimes|string|max:10',
            'nationality' => 'sometimes|string|max:100',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
   try {
        // Mettre à jour l'email dans la table users
        if ($request->has('email')) {
            $user->email = $request->email;
            $user->save();
        }
        
        // Map camelCase form field names to snake_case database fields
        $personalInfoFields = [
            'name' => 'name',
            'surname' => 'surname',
            'birthdate' => 'birthdate',
            'gender' => 'gender',
            'address' => 'address',
            'emergencyContact' => 'emergency_contact',
            'maritalStatus' => 'marital_status',
            'bloodType' => 'blood_type',
            'nationality' => 'nationality',
        ];
        
        // Update personal info fields
        foreach ($personalInfoFields as $formField => $dbField) {
            if ($request->has($formField)) {
                $personalInfo->$dbField = $request->$formField;
            }
        }
        
        $personalInfo->save();
        
        // Prepare response data
        $responseData = [
            'id' => $user->id,
            'email' => $user->email,
            'name' => $personalInfo->name,
            'surname' => $personalInfo->surname,
             'birthdate' => $personalInfo->birthdate ? $personalInfo->birthdate->format('Y-m-d') : null,
            'gender' => $personalInfo->gender,
            'address' => $personalInfo->address,
            'emergencyContact' => $personalInfo->emergency_contact,
            'maritalStatus' => $personalInfo->marital_status,
            'bloodType' => $personalInfo->blood_type,
            'nationality' => $personalInfo->nationality,
            'profile_image' => $personalInfo->profile_image,
        ];
        
        return response()->json([
            'status' => 'success',
            'message' => 'Profile updated successfully',
            'data' => $responseData
        ]);
           } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => 'An error occurred while updating the profile',
            'error' => $e->getMessage()
        ], 500);
    }
    }
    
    /**
     * Update the patient's profile image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfileImage(Request $request)
    {
       $patient = Patient::first();
        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }   
        
 
        
         
     
        
        // Get or create personal info record
        $personalInfo = PersonalInfo::firstOrCreate(['patient_id' => $patient->id]);
        
        // Valider l'image
        $validator = Validator::make($request->all(), [
            'profile_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
        
        // Delete old image if exists
        if ($personalInfo->profile_image) {
            $oldImagePath = str_replace('/storage/', '', $personalInfo->profile_image);
            if (Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }
        
        // Store new image
        $profileImage = $request->file('profile_image');
        $path = $profileImage->store('profile-images', 'public');
        $personalInfo->profile_image = '/storage/' . $path;
        $personalInfo->save();
        
        return response()->json([
            'status' => 'success',
            'message' => 'Profile image updated successfully',
            'data' => [
                'profile_image' => $personalInfo->profile_image
            ]
        ]);
    }
    
    /**
     * Get the authenticated user's profile.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProfile()
    {
         // Récupérer le premier patient 
        $patient = Patient::first();

        
            if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }
        
        $user = $patient->user;

        // Find the patient record associated with this user
               $personalInfo = PersonalInfo::where('patient_id', $patient->id)->first();
        
        $data = [
            'id' => $user->id,
            'email' => $user->email,
        ];
        
        if ($personalInfo) {
            $data = array_merge($data, [
                'name' => $personalInfo->name,
                'surname' => $personalInfo->surname,
                'birthdate' => $personalInfo->birthdate,
                'gender' => $personalInfo->gender,
                'address' => $personalInfo->address,
                'emergencyContact' => $personalInfo->emergency_contact,
                'maritalStatus' => $personalInfo->marital_status,
                'bloodType' => $personalInfo->blood_type,
                'nationality' => $personalInfo->nationality,
                'profile_image' => $personalInfo->profile_image,
            ]);
        }
        
 
             // Renvoyer toutes les informations disponibles
      return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }



/**
 * Change the user's password.
 *
 * @param  \Illuminate\Http\Request  $request
 * @return \Illuminate\Http\JsonResponse
 */
public function changePassword(Request $request)
{

    // Récupérer le premier patient
        $patient = Patient::first();
            if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient not found'
            ], 404);
        }
         $user = $patient->user;
        
        $validator = Validator::make($request->all(), [
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8',
        ]);
             if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }
                $dto = new ChangePasswordDTO(
            $user->id,
            $request->currentPassword,
            $request->newPassword
        );
        
        $service = app(ChangePasswordService::class);
        $success = $service->execute($dto);
        
        if (!$success) {
            return response()->json([
                'status' => 'error',
                'message' => 'Le mot de passe actuel est incorrect.'
           ], 422);
                     }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Mot de passe changé avec succès!'
        ]); 
}

}
