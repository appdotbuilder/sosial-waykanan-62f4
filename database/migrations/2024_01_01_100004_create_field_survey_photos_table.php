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
        Schema::create('field_survey_photos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('field_survey_id')->constrained()->onDelete('cascade');
            $table->string('photo_path');
            $table->text('description')->nullable();
            $table->string('photo_type')->nullable();
            $table->timestamps();
            
            $table->index('field_survey_id');
            $table->index('photo_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('field_survey_photos');
    }
};