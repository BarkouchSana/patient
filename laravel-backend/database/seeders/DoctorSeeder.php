<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentDoctor;

class DoctorSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            EloquentDoctor::create([
                'name' => fake()->name(),
                'specialty' => fake()->randomElement(['Cardiology', 'Neurology', 'Pediatrics', 'Dermatology', 'General']),
                'license_number' => strtoupper(fake()->bothify('MED####')),
                'availability' => 'Monday to Friday',
                'education' => fake()->sentence(3),
                'experience' => fake()->paragraph(),
            ]);
        }
    }
}
