<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentAppointment as Appointment;
use App\Infrastructure\Models\EloquentDoctor;
use App\Infrastructure\Models\EloquentPatient;
use App\Infrastructure\Models\EloquentTimeSlot;
class AppointmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $patients = EloquentPatient::all();
        $doctors = EloquentDoctor::all();
        $slots = EloquentTimeSlot::all();

        foreach ($patients as $patient) {
            Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $doctors->random()->id,
                'time_slot_id' => $slots->random()->id,
                'title' => 'Consultation médicale',
                'date' => now()->addDays(rand(1, 30)),
                'reason' => fake()->sentence(),
                'status' => 'scheduled',
            ]);
        }
    }
}
