<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->string('causer_id')->nullable()->change();
            $table->string('subject_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropIndex(['causer_type', 'causer_id']);
            $table->dropIndex(['subject_type', 'subject_id']);
            
            $table->unsignedBigInteger('causer_id')->nullable()->change();
            $table->unsignedBigInteger('subject_id')->nullable()->change();
            
            $table->index(['causer_type', 'causer_id']);
            $table->index(['subject_type', 'subject_id']);
        });
    }
};
