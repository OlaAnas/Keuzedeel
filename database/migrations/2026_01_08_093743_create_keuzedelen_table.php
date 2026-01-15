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
        Schema::create('keuzedelen', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->text('description')->nullable();

            $table->foreignId('teacher_id')->nullable()
                ->constrained('users')->cascadeOnUpdate()->nullOnDelete();

            $table->string('requirement')->nullable();
            $table->string('level')->nullable();

            $table->boolean('repeatable')->default(false);
            $table->enum('state', ['active', 'inactive', 'planned'])->default('planned');

            $table->foreignId('study_id')->constrained('studies')->cascadeOnUpdate()->restrictOnDelete();
            $table->foreignId('period_id')->constrained('periods')->cascadeOnUpdate()->restrictOnDelete();

            $table->unsignedInteger('min_students')->nullable();
            $table->unsignedInteger('max_students')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keuzedelen');
    }
};
