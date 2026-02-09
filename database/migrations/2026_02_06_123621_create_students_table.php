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
        Schema::create('students', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('school_id')->constrained()->cascadeOnDelete();
            $table->string('admission_number');
            $table->unsignedBigInteger('current_class_id')->nullable();
            $table->unsignedBigInteger('class_arm_id')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('gender')->nullable();
            $table->string('blood_group')->nullable();
            $table->text('address')->nullable();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_email')->nullable();
            $table->string('guardian_relationship')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->text('medical_conditions')->nullable();
            $table->string('previous_school')->nullable();
            $table->date('admission_date')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();

            $table->unique(['school_id', 'admission_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
