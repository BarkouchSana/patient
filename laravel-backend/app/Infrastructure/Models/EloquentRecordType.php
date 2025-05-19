<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EloquentRecordType extends Model
{
    use HasFactory;

    protected $table = 'record_types';

    protected $fillable = [
        'name',
        'code',
        'description',
        'metadata_schema',
        'requires_attachment',
        'is_active',
    ];

    protected $casts = [
        'metadata_schema' => 'array',
        'requires_attachment' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Get the medical records associated with this record type.
     */
    public function medicalRecords(): HasMany
    {
        return $this->hasMany(EloquentMedicalRecord::class, 'record_type_id');
    }
}