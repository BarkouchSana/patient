<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalInfo extends Model
{
    use HasFactory;
    protected $table = 'personal_infos';

    protected $fillable = [
        'patient_id',
         'name', 
         'surname',
          'birthdate',
        'gender',
         'address', 
         'emergency_contact',
        'marital_status',
         'blood_type',
          'nationality',
        'profile_image',
    ];
 
    protected $casts = [
        'birthdate' => 'date', // Ajouté
    ];
    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}
