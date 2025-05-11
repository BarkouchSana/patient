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
        Schema::create('appointments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('patient_id')
                  ->constrained('patients')
                  ->onDelete('cascade');
            $table->foreignId('doctor_id')
                  ->nullable()
                  ->constrained('doctors')
                  ->onDelete('set null');
            $table->foreignId('time_slot_id')
            ->constrained('time_slots')
            
            ->onDelete('cascade');  
              
            $table->string('title');
            $table->dateTime('date');
             
            $table->text('reason')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled' , 'pending_change'])->default('scheduled');
         
            $table->text('cancel_reason')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
