<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentTimeSlot extends Model
{
    use HasFactory;
    protected $table = 'time_slots';
    protected $fillable = [
        'start_time',
        'end_time',
        'is_active',
    ];

    public function appointments(): HasMany
    {
        return $this->hasMany(EloquentAppointment::class);
    }
}