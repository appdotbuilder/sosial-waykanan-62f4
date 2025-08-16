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
        Schema::create('application_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->onDelete('cascade');
            $table->string('document_type');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('mime_type');
            $table->integer('file_size');
            $table->boolean('is_verified')->default(false);
            $table->text('verification_notes')->nullable();
            $table->timestamps();
            
            $table->index(['application_id', 'document_type']);
            $table->index('is_verified');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('application_documents');
    }
};