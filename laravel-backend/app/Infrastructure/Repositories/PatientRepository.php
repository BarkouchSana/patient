<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Patient;
use App\Domain\Interfaces\PatientRepositoryInterface;
use App\Infrastructure\Models\EloquentPatient;

class PatientRepository implements PatientRepositoryInterface
{
    public function findByUserId(int $userId): ?Patient
    {
        $m = EloquentPatient::where('user_id',$userId)->first();
        if (! $m) return null;

        $p = new Patient();
        $p->id               = $m->id;
        $p->userId           = $m->user_id;
        $p->registrationDate = $m->registration_date;
        $p->createdAt        = $m->created_at;
        $p->updatedAt        = $m->updated_at;
        return $p;
    }

    public function save(Patient $patient): Patient
    {
        $m = EloquentPatient::updateOrCreate(
            ['id' => $patient->id],
            [
              'user_id'           => $patient->userId,
              'registration_date' => $patient->registrationDate,
            ]
        );
        $patient->id = $m->id;
        return $patient;
    }
}
