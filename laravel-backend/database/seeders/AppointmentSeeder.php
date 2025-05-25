<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\TimeSlot;
use Carbon\Carbon;

class AppointmentSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        $doctors = Doctor::all();
        $timeSlots = TimeSlot::all();
        
        $statuses = ['scheduled', 'completed', 'cancelled', 'pending_change'];
        
        $reasons = [
            'Examen physique annuel',
            'Consultation de suivi',
            'Symptômes grippaux et fièvre',
            'Gestion de la douleur chronique',
            'Surveillance de la pression artérielle',
            'Contrôle du diabète',
            'Évaluation d\'une éruption cutanée',
            'Problèmes respiratoires',
            'Problèmes digestifs',
            'Évaluation de douleurs articulaires',
            'Révision de médication',
            'Suivi post-opératoire',
            'Symptômes d\'allergie',
            'Visite de soins préventifs',
            'Consultation pour maux de tête'
        ];
        
        $cancelReasons = [
            'Patient a demandé un report',
            'Médecin indisponible en raison d\'une urgence',
            'Patient se sent mieux',
            'Conflit avec un autre rendez-vous',
            'Problèmes de transport',
            'Urgence familiale',
            'Conditions météorologiques'
        ];

        // Créer 25 rendez-vous
        for ($i = 0; $i < 25; $i++) {
            $patient = $patients->random();
            $doctor = $doctors->random();
            $timeSlot = $timeSlots->random();
            
            // 50% de chance que ce soit un rendez-vous passé, 50% futur
            $isPast = rand(0, 1) === 1;
            
            if ($isPast) {
                $date = Carbon::now()->subDays(rand(1, 90));
                $status = $statuses[array_rand([1, 2])]; // completed ou cancelled
            } else {
                $date = Carbon::now()->addDays(rand(1, 30));
                $status = $statuses[array_rand([0, 3])]; // scheduled ou pending_change
            }
            
            $cancelReason = null;
            if ($status === 'cancelled') {
                $cancelReason = $cancelReasons[array_rand($cancelReasons)];
            }
            
            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctor->id,
                'time_slot_id' => $timeSlot->id,
                'title' => $isPast ? 'Consultation passée' : 'Rendez-vous à venir',
                'date' => $date->format('Y-m-d'),
                'reason' => $reasons[array_rand($reasons)],
                'status' => $status,
                'cancel_reason' => $cancelReason
            ]);
        }
    }
}