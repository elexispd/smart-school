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
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['current_class_id', 'class_arm_id']);
        });
        
        Schema::table('students', function (Blueprint $table) {
            $table->foreignUuid('current_class_id')->nullable()->after('admission_number')->constrained('classes')->nullOnDelete();
            $table->foreignUuid('class_arm_id')->nullable()->after('current_class_id')->constrained('class_arms')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropForeign(['current_class_id']);
            $table->dropForeign(['class_arm_id']);
            $table->dropColumn(['current_class_id', 'class_arm_id']);
        });
        
        Schema::table('students', function (Blueprint $table) {
            $table->unsignedBigInteger('current_class_id')->nullable();
            $table->unsignedBigInteger('class_arm_id')->nullable();
        });
    }
};
