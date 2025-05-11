<?php
namespace App\Infrastructure\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentAppointment extends Model
{
    protected $table = 'appointments';
    use HasFactory;
    protected $fillable = [
        'patient_id',
         'doctor_id',
          'time_slot_id',
        'title',
        'date',
        'reason',
        'status',
        'cancel_reason'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(EloquentPatient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(EloquentDoctor::class);
    }

       public function timeSlot()
    {
        return $this->belongsTo(EloquentTimeSlot::class, 'time_slot_id');
    }
}

