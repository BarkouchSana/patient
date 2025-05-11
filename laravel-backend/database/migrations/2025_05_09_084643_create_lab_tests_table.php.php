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
        Schema::create('lab_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chart_patient_id')->constrained()->cascadeOnDelete();
            $table->string('test_name');
            $table->string('test_code')->nullable();
            $table->string('urgency')->default('routine'); // routine, urgent, stat
            $table->dateTime('requested_date');
            $table->dateTime('scheduled_date')->nullable();
            $table->string('lab_name')->nullable(); // Which lab to perform the test
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lab_tests');
    }
};
