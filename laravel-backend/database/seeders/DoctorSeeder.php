<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Doctor;

class DoctorSeeder extends Seeder
{
    public function run()
    {
        Doctor::create([
            'name' => 'Dr. Emily Wilson',
            'specialty' => 'Cardiologie',
            'license_number' => 'MD-12345',
            'availability' => 'Lundi, Mercredi, Vendredi: 9H-17H',
            'education' => 'Université de Médecine de Paris, Résidence à l\'Hôpital Saint-Antoine',
            'experience' => '15 ans d\'expérience en traitement des maladies cardiovasculaires'
        ]);

        Doctor::create([
            'name' => 'Dr. Robert Brown',
            'specialty' => 'Orthopédie',
            'license_number' => 'MD-23456',
            'availability' => 'Lundi, Mardi, Jeudi: 8H-16H',
            'education' => 'Faculté de Médecine de Lyon, Fellowship à l\'Hôpital de la Croix-Rousse',
            'experience' => '12 ans d\'expérience en chirurgie de remplacement articulaire'
        ]);

        Doctor::create([
            'name' => 'Dr. Jennifer Lee',
            'specialty' => 'Dermatologie',
            'license_number' => 'MD-34567',
            'availability' => 'Mardi, Jeudi, Vendredi: 10H-18H',
            'education' => 'Université de Médecine de Bordeaux, Résidence à l\'Hôpital Saint-André',
            'experience' => '10 ans d\'expérience en dermatologie médicale et esthétique'
        ]);

        Doctor::create([
            'name' => 'Dr. James Scott',
            'specialty' => 'Neurologie',
            'license_number' => 'MD-45678',
            'availability' => 'Lundi, Mercredi, Vendredi: 8H-15H',
            'education' => 'Faculté de Médecine de Marseille, Fellowship en Neurologie à l\'Hôpital de la Timone',
            'experience' => '18 ans d\'expérience dans le diagnostic et le traitement des troubles neurologiques'
        ]);

        Doctor::create([
            'name' => 'Dr. Maria Gonzalez',
            'specialty' => 'Pédiatrie',
            'license_number' => 'MD-56789',
            'availability' => 'Lundi-Vendredi: 9H-17H',
            'education' => 'Université de Médecine de Montpellier, Résidence à l\'Hôpital Arnaud de Villeneuve',
            'experience' => '14 ans d\'expérience en pédiatrie, avec intérêt pour le développement de l\'enfant'
        ]);
    }
}