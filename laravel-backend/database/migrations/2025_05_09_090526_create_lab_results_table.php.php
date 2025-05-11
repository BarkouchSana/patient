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
        Schema::create('lab_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medical_record_id')->constrained()->cascadeOnDelete();
            $table->dateTime('result_date');
            $table->string('performed_by')->nullable(); // Lab technician or facility
            $table->string('test_path')->nullable(); // File path for test document
            $table->string('status')->default('pending'); // pending, completed, reviewed
            $table->text('interpretation')->nullable(); // Doctor's interpretation of results
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_results');
    }
};
