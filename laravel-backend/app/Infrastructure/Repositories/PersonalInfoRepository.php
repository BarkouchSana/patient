<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Entities\PersonalInfo;
use App\Domain\Interfaces\PersonalInfoRepositoryInterface;
use App\Infrastructure\Models\EloquentPersonalInfo;

class PersonalInfoRepository implements PersonalInfoRepositoryInterface
{
    public function findByPatientId(int $patientId): ?PersonalInfo
    {
        $m = EloquentPersonalInfo::where('patient_id',$patientId)->first();
        if (! $m) return null;

        $pi = new PersonalInfo();
        foreach ([
            'id','patient_id','name','surname','birthdate','gender',
            'address','emergency_contact','marital_status','blood_type','nationality',
            'photo',
            'created_at','updated_at'
        ] as $f) {
            $prop = lcfirst(str_replace('_','',ucwords($f,'_')));
            $pi->$prop = $m->$f;
        }
        return $pi;
    }

    public function save(PersonalInfo $info): PersonalInfo
    {
        $m = EloquentPersonalInfo::updateOrCreate(
            ['id' => $info->id],
            [
              'patient_id'       => $info->patientId,
              'name'             => $info->name,
              'surname'          => $info->surname,
              'birthdate'        => $info->birthdate,
              'gender'           => $info->gender,
              'address'          => $info->address,
              'emergency_contact'=> $info->emergencyContact,
              'marital_status'   => $info->maritalStatus,
              'blood_type'       => $info->bloodType,
              'nationality'      => $info->nationality,
              'photo'            => $info->photo,
            ]
        );
        $info->id = $m->id;
        return $info;
    }
}
