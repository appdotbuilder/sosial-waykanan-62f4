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
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->string('application_number')->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('assistance_type_id')->constrained()->onDelete('cascade');
            $table->string('applicant_name');
            $table->string('nik', 16);
            $table->string('phone');
            $table->text('address');
            $table->string('village');
            $table->string('district');
            $table->decimal('requested_amount', 12, 2)->nullable();
            $table->text('reason');
            $table->enum('status', ['draft', 'submitted', 'under_review', 'field_survey', 'approved', 'rejected', 'completed'])->default('draft');
            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamps();
            
            $table->index('application_number');
            $table->index('nik');
            $table->index('status');
            $table->index(['status', 'created_at']);
            $table->index('village');
            $table->index('district');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};