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
        Schema::create('completed_keuzedelen', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')->constrained('students')->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('keuzedeel_code'); // always from import
            $table->foreignId('keuzedeel_id')->nullable()
                ->constrained('keuzedelen')->cascadeOnUpdate()->nullOnDelete();

            $table->date('completed_at')->nullable();
            $table->enum('source', ['import', 'manual'])->default('import');

            $table->timestamps();

            $table->unique(['student_id', 'keuzedeel_code']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('completed_keuzedelen');
    }
};
