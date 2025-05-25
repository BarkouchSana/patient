<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PersonalInfo;
use App\Models\Patient;

class PersonalInfoSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        
        $personalInfoData = [
            [
                'name' => 'Sarah',
                'surname' => 'Johnson',
                'birthdate' => '1985-04-12',
                'gender' => 'female',
                'address' => '123 Rue Principale, Apt 4B, Paris 75001',
                'emergency_contact' => 'John Johnson (Mari): +33 6 12 34 56 78',
                'marital_status' => 'married',
                'blood_type' => 'A+',
                'nationality' => 'Française',
                'profile_image' => null
            ],
            [
                'name' => 'Michael',
                'surname' => 'Rodriguez',
                'birthdate' => '1978-07-23',
                'gender' => 'male',
                'address' => '456 Avenue du Parc, Suite 7, Lyon 69002',
                'emergency_contact' => 'Lisa Rodriguez (Épouse): +33 6 23 45 67 89',
                'marital_status' => 'married',
                'blood_type' => 'O-',
                'nationality' => 'Espagnole',
                'profile_image' => null
            ],
            [
                'name' => 'Emma',
                'surname' => 'Thompson',
                'birthdate' => '1992-11-30',
                'gender' => 'female',
                'address' => '789 Boulevard Saint-Michel, Apt 12C, Paris 75005',
                'emergency_contact' => 'Rebecca Thompson (Mère): +33 6 34 56 78 90',
                'marital_status' => 'single',
                'blood_type' => 'B+',
                'nationality' => 'Britannique',
                'profile_image' => null
            ],
            [
                'name' => 'David',
                'surname' => 'Chen',
                'birthdate' => '1965-03-18',
                'gender' => 'male',
                'address' => '101 Rue du Chêne, Bordeaux 33000',
                'emergency_contact' => 'Grace Chen (Fille): +33 6 45 67 89 01',
                'marital_status' => 'widowed',
                'blood_type' => 'AB+',
                'nationality' => 'Chinoise-Française',
                'profile_image' => null
            ],
            [
                'name' => 'Olivia',
                'surname' => 'Martinez',
                'birthdate' => '1989-09-05',
                'gender' => 'female',
                'address' => '222 Rue des Saules, Toulouse 31000',
                'emergency_contact' => 'Carlos Martinez (Frère): +33 6 56 78 90 12',
                'marital_status' => 'divorced',
                'blood_type' => 'O+',
                'nationality' => 'Franco-Mexicaine',
                'profile_image' => null
            ]
        ];

        foreach ($patients as $index => $patient) {
            if (isset($personalInfoData[$index])) {
                $infoData = $personalInfoData[$index];
                $infoData['patient_id'] = $patient->id;
                PersonalInfo::create($infoData);
            }
        }
    }
}