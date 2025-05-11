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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('patient_id')->nullable(); // For patients without user accounts
            $table->foreignId('doctor_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('record_type_id')->constrained();
            $table->string('title');
            $table->text('description')->nullable();
            $table->json('metadata')->nullable(); // Structured data specific to record type
            $table->timestamp('record_date'); // When the medical event occurred
            $table->boolean('is_confidential')->default(false);
            $table->string('status')->default('active'); // active, archived, pending_review
            $table->string('version')->default('1.0');

            // Champs supplémentaires (deuxième migration)
            $table->string('record_class_type')->nullable();
            $table->unsignedBigInteger('record_class_id')->nullable();
            $table->unsignedBigInteger('chart_patient_id')->nullable();

            $table->timestamps();
            $table->softDeletes(); // Enable soft deletes

            // Indexes pour les performances
            $table->index(['user_id', 'patient_id']);
            $table->index('record_date');
            $table->index('status');
            $table->index(['record_class_type', 'record_class_id']);
            $table->index('chart_patient_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
