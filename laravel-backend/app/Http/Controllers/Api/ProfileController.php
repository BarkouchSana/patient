<?php

namespace App\Http\Controllers\APi;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
 
use App\Models\Patient;
use App\Models\PersonalInfo;
use App\Http\Controllers\Controller;
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
        $user = User::find(1);
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }
        
        // Find the patient record associated with this user
        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient record not found'
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
        
        // Update email in the users table
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
            'birthdate' => $personalInfo->birthdate,
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
    }
    
    /**
     * Update the user's profile image.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateProfileImage(Request $request)
    {
        $user = User::find(1);
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }
        
        // Find the patient record associated with this user
        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient record not found'
            ], 404);
        }
        
        // Get or create personal info record
        $personalInfo = PersonalInfo::firstOrCreate(['patient_id' => $patient->id]);
        
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
        $user = User::find(1);
        
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthenticated'
            ], 401);
        }
        
        // Find the patient record associated with this user
        $patient = Patient::where('user_id', $user->id)->first();
        
        if (!$patient) {
            return response()->json([
                'status' => 'error',
                'message' => 'Patient record not found'
            ], 404);
        }
        
        // Get personal info or return empty data
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
        
        return response()->json([
            'status' => 'success',
            'data' => $data
        ]);
    }
}
