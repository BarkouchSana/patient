<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
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
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

       public function timeSlot()
    {
        return $this->belongsTo(TimeSlot::class, 'time_slot_id');
    }



     // Accesseurs optionnels pour startTime, endTime, doctorName si un accès direct est souhaité
     public function getStartTimeAttribute()
     {
         return $this->timeSlot?->start_time;
     }
 
     public function getEndTimeAttribute()
     {
         return $this->timeSlot?->end_time;
     }
 
     public function getDoctorNameAttribute()
     {
         // Supposant que votre modèle Doctor a un attribut 'name' ou une concaténation
         return $this->doctor?->user?->name; // Ajustez selon la structure de votre modèle Doctor/User
     }
}

