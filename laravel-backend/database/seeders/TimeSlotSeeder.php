<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TimeSlot;

class TimeSlotSeeder extends Seeder
{
    public function run()
    {
        $timeSlots = [
            ['start_time' => '08:00:00', 'end_time' => '08:30:00'],
            ['start_time' => '08:30:00', 'end_time' => '09:00:00'],
            ['start_time' => '09:00:00', 'end_time' => '09:30:00'],
            ['start_time' => '09:30:00', 'end_time' => '10:00:00'],
            ['start_time' => '10:00:00', 'end_time' => '10:30:00'],
            ['start_time' => '10:30:00', 'end_time' => '11:00:00'],
            ['start_time' => '11:00:00', 'end_time' => '11:30:00'],
            ['start_time' => '11:30:00', 'end_time' => '12:00:00'],
            ['start_time' => '14:00:00', 'end_time' => '14:30:00'],
            ['start_time' => '14:30:00', 'end_time' => '15:00:00'],
            ['start_time' => '15:00:00', 'end_time' => '15:30:00'],
            ['start_time' => '15:30:00', 'end_time' => '16:00:00'],
            ['start_time' => '16:00:00', 'end_time' => '16:30:00'],
            ['start_time' => '16:30:00', 'end_time' => '17:00:00'],
            ['start_time' => '17:00:00', 'end_time' => '17:30:00'],
            ['start_time' => '17:30:00', 'end_time' => '18:00:00']
        ];

        foreach ($timeSlots as $slotData) {
            TimeSlot::create($slotData);
        }
    }
}