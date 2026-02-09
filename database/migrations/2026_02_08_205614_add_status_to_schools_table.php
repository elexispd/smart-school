<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            if (!Schema::hasColumn('schools', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('approved')->after('is_active');
            }
            if (!Schema::hasColumn('schools', 'approved_by')) {
                $table->string('approved_by')->nullable()->after('is_active');
            }
            if (!Schema::hasColumn('schools', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
        });
    }

    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn(['status', 'approved_by', 'approved_at']);
        });
    }
};
