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
        Schema::create('waitlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('keuzedeel_id');
            $table->unsignedBigInteger('period_id');
            $table->integer('preference_order')->default(1); // 1st choice, 2nd choice, etc.
            $table->enum('status', ['waiting', 'approved', 'rejected', 'cancelled'])->default('waiting');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('keuzedeel_id')->references('id')->on('keuzedelen')->onDelete('cascade');
            $table->foreign('period_id')->references('id')->on('periods')->onDelete('cascade');

            // Ensure one waitlist entry per student per keuzedeel per period
            $table->unique(['user_id', 'keuzedeel_id', 'period_id']);

            // Index for efficient queries
            $table->index(['period_id', 'keuzedeel_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('waitlists');
    }
};
