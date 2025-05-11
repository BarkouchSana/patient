<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Models\EloquentTimeSlot;

class TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        $timeSlots = [
            ['start_time' => '09:00:00', 'end_time' => '09:30:00'],
            ['start_time' => '09:30:00', 'end_time' => '10:00:00'],
            ['start_time' => '10:00:00', 'end_time' => '10:30:00'],
            ['start_time' => '10:30:00', 'end_time' => '11:00:00'],
        ];

        foreach ($timeSlots as $slot) {
            EloquentTimeSlot::create($slot);
        }
    }
}
