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
        Schema::create('class_arm_subject', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('class_arm_id')->constrained()->cascadeOnDelete();
            $table->foreignUuid('subject_id')->constrained()->cascadeOnDelete();
            $table->boolean('is_compulsory')->default(true);
            $table->timestamps();
            
            $table->unique(['class_arm_id', 'subject_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_arm_subject');
    }
};
