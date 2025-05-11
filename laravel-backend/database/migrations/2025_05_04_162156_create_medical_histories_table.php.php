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
        Schema::create('medical_histories', function (Blueprint $table) {
             
                $table->id();
                $table->unsignedBigInteger('patient_id');
                $table->json('currentMedicalConditions')->nullable();
                $table->json('pastSurgeries')->nullable();
                $table->json('chronicDiseases')->nullable();
                $table->json('currentMedications')->nullable();
                $table->json('allergies')->nullable();
                $table->timestamp('lastUpdated')->nullable();
                $table->timestamps();
                $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_histories');
    }
};
