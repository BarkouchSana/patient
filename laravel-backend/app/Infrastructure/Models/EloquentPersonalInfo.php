<?php
namespace App\Infrastructure\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EloquentPersonalInfo extends Model
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
 

    public function patient()
    {
        return $this->belongsTo(EloquentPatient::class, 'patient_id');
    }
}
