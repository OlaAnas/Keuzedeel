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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('keuzedeel_id')->constrained('keuzedelen')->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedTinyInteger('choice_number'); // 1/2/3
            $table->enum('status', ['pending', 'approved', 'rejected', 'waitlist', 'cancelled'])->default('pending');

            $table->timestamps();

            $table->unique(['student_id', 'period_id', 'choice_number']);
            $table->unique(['student_id', 'period_id', 'keuzedeel_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
