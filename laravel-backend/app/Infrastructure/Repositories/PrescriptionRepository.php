<?php
namespace App\Infrastructure\Repositories;

use App\Domain\Entities\Prescription;
use App\Domain\Interfaces\PrescriptionRepositoryInterface;
use App\Infrastructure\Models\EloquentPrescription;

class PrescriptionRepository implements PrescriptionRepositoryInterface
{
    public function findActiveByPatientId(int $patientId): array
    {
        $today = date('Y-m-d');
        $rows = EloquentPrescription::where('patient_id',$patientId)
                 ->where('end_date','>=',$today)
                 ->get();

        return $rows->map(fn($m) => tap(new Prescription(), function($p) use($m){
            $p->id        = $m->id;
            $p->patientId = $m->patient_id;
            $p->name      = $m->name;
            $p->dosage    = $m->dosage;
            $p->startDate = $m->start_date;
            $p->endDate   = $m->end_date;
            $p->quantity  = $m->quantity;
            $p->doctor    = $m->doctor;
        }))->all();
    }
}
