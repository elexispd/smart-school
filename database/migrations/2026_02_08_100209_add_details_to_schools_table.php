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
        Schema::table('schools', function (Blueprint $table) {
            $table->string('acronym')->after('name');
            $table->string('email')->after('acronym');
            $table->string('phone')->after('email');
            $table->string('moto')->nullable()->after('phone');
            $table->string('address')->after('moto');
            $table->string('city')->after('address');
            $table->string('state')->after('city');
            $table->string('country')->after('state');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schools', function (Blueprint $table) {
            $table->dropColumn([
                'acronym',
                'email',
                'phone',
                'moto',
                'address',
                'city',
                'state',
                'country',
            ]);
        });
    }
};
