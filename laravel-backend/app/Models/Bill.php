<?php

namespace App\Models; // Ou App\Infrastructure\Models si c'est votre convention

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient; // Ou App\Infrastructure\Models\EloquentPatient

class Bill extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'amount',
        'issue_date',
        'due_date',
        'status',
        'notes',
        'pdf_path',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    public function patient()
    {
        // Ajustez le namespace si EloquentPatient est dans App\Infrastructure\Models
        return $this->belongsTo(Patient::class); // Ou EloquentPatient::class
    }
}