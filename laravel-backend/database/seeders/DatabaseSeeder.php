<?php

namespace Database\Seeders;

use App\Domain\Entities\Prescription;
use App\Models\Bill;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Type\Time;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // // Check if test user exists before creating it
        // $testUser = User::where('email', 'test@example.com')->first();
        
        // if (!$testUser) {
        //     User::factory()->create([
        //         'name' => 'Test User',
        //         'email' => 'test@example.com',
        //     ]);
        // }

        // Call our custom seeders in the right order
        $this->call([
            UserSeeder::class,
            PatientSeeder::class,
            PersonalInfoSeeder::class,
            DoctorSeeder::class,
            TimeSlotSeeder::class,
            AppointmentSeeder::class,
            PrescriptionSeeder::class,
            MedicalHistorySeeder::class,
            LabTestDataSeeder::class,
            BillSeeder::class,
            
        ]);
    }
}
