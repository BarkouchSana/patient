<?php

namespace App\UI\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Application\Services\GetProfileService;
 
use App\Application\Services\UpdateProfileService;
use App\Application\DTOs\UpdateProfileDTO;
use Illuminate\Support\Facades\Storage;
 
use App\Infrastructure\Models\EloquentUser;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        $user = EloquentUser::find(1); // Exemple : utilisateur avec ID 1

        if (! $user) {
            return response()->json(['message' => 'Utilisateur non trouvé'], 404);
        }

        $patient = $user->patient;
        $personalInfo = $patient?->personalInfo;

        return response()->json([
            'name' => $personalInfo?->name,
            'surname' => $personalInfo?->surname,
            'birthdate' => $personalInfo?->birthdate,
            'gender' => $personalInfo?->gender,
            'address' => $personalInfo?->address,
            'emergencyContact' => $personalInfo?->emergency_contact,
            'maritalStatus' => $personalInfo?->marital_status,
            'bloodType' => $personalInfo?->blood_type,
            'nationality' => $personalInfo?->nationality,
            'photo'            => $personalInfo?->photo ? Storage::url($personalInfo->photo) : null,
            'email'            => $user->email, 
        ]);
    }
 
    public function update(Request $request): JsonResponse
    {
        try {
            $user = EloquentUser::find(1); // Example : utilisateur avec ID 1

            if (!$user) {
                return response()->json(['message' => 'Utilisateur non trouvé'], 404);
            }

            $patient = $user->patient;
            $personalInfo = $patient?->personalInfo;

            // Log the incoming request data
            Log::info('Request data:', $request->all());
            Log::info('Files:', $request->allFiles());

            // Validate the input
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'surname' => 'required|string|max:255',
                'birthdate' => 'required|date',
                'gender' => 'nullable|string|in:male,female',
                'address' => 'nullable|string|max:255',
                'emergencyContact' => 'nullable|string|max:255',
                'maritalStatus' => 'nullable|string|in:single,married',
                'bloodType' => 'nullable|string|max:3',
                'nationality' => 'nullable|string|max:255',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            ]);

            // Handle photo upload
            if ($request->hasFile('photo')) {
                // Delete old photo if exists
                if ($personalInfo && $personalInfo->photo) {
                    Storage::disk('public')->delete($personalInfo->photo);
                }
                
                // Store new photo
                $photo = $request->file('photo');
                $filename = time() . '_' . $photo->getClientOriginalName();
                $path = $photo->storeAs('photos', $filename, 'public');
                $validatedData['photo'] = $path;
            }

            // Update personal info
            if ($personalInfo) {
                $personalInfo->update([
                    'name' => $validatedData['name'],
                    'surname' => $validatedData['surname'],
                    'birthdate' => $validatedData['birthdate'],
                    'gender' => $validatedData['gender'],
                    'address' => $validatedData['address'],
                    'emergency_contact' => $validatedData['emergencyContact'],
                    'marital_status' => $validatedData['maritalStatus'],
                    'blood_type' => $validatedData['bloodType'],
                    'nationality' => $validatedData['nationality'],
                    'photo' => $validatedData['photo'] ?? $personalInfo->photo,
                ]);
            }

            // Update user email
            $user->update([
                'email' => $validatedData['email'],
            ]);

            return response()->json([
                'message' => 'Profile updated successfully',
                'data' => [
                    'photo' => $validatedData['photo'] ?? $personalInfo->photo
                ]
            ]);

        } catch (ValidationException $e) {
            Log::error('Validation error:', $e->errors());
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error updating profile:', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'An error occurred while updating the profile'], 500);
        }
    }
}