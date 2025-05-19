<?php
 
namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EloquentLabResult extends Model
{
    use HasFactory;

    protected $table = 'lab_results';

    protected $fillable = [
        'medical_record_id',
        'result_date',
        'performed_by',
        'test_path',
        'status', // 'pending', 'completed', 'reviewed', 'cancelled'
        'interpretation',
    ];

    protected $casts = [
        'result_date' => 'datetime',
    ];

    public function medicalRecord(): BelongsTo
    {
        return $this->belongsTo(EloquentMedicalRecord::class, 'medical_record_id');
    }
 
}