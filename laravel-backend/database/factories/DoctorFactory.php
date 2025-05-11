<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'specialty' => $this->faker->randomElement(['Cardiology', 'Neurology', 'Pediatrics']),
            'license_number' => $this->faker->uuid(),
            'availability' => 'Mon-Fri',
            'education' => $this->faker->sentence(3),
            'experience' => $this->faker->paragraph(),
        ];
    }
}
