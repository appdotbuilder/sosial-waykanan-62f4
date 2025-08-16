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
        Schema::create('field_surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->foreignId('surveyor_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('survey_date');
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->text('findings');
            $table->text('recommendations');
            $table->enum('recommendation_status', ['approve', 'reject', 'need_revision'])->default('approve');
            $table->timestamps();
            
            $table->index('application_id');
            $table->index('surveyor_id');
            $table->index('survey_date');
            $table->index('recommendation_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_surveys');
    }
};