<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('patient_id')->constrained()->onDelete('cascade');
            $table->string('blood_pressure_systolic')->nullable();   // Pour "120"
            $table->string('blood_pressure_diastolic')->nullable();  // Pour "80"
            $table->unsignedSmallInteger('pulse_rate')->nullable(); // Pour "72". L'unité "bpm" sera gérée côté frontend ou implicite
            $table->decimal('temperature', 4, 1)->nullable();       // Pour "36.7"
            $table->string('temperature_unit', 10)->nullable()->default('°C'); // Pour "°C"
            $table->unsignedSmallInteger('respiratory_rate')->nullable(); // Pour "16". L'unité "breaths/min" sera gérée côté frontend ou implicite

            $table->unsignedSmallInteger('oxygen_saturation')->nullable(); // Pour "98". L'unité "%" sera gérée côté frontend ou implicite
            $table->decimal('weight', 5, 2)->nullable();            // Pour "75"
            $table->string('weight_unit', 10)->nullable()->default('kg'); // Pour "kg"
        
            $table->decimal('height', 5, 2)->nullable();            // Pour "176" (pourrait être un entier si toujours en cm)
            $table->string('height_unit', 10)->nullable()->default('cm'); // Pour "cm"
        
            $table->text('notes')->nullable();
            $table->timestamps();
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
