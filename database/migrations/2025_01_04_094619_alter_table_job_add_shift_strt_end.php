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
        Schema::table('jobs_c', function (Blueprint $table) {
            $table->time('shift_start')->default(null)->after('phone');
            $table->time('shift_end')->default(null)->after('shift_start');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('jobs_c', function (Blueprint $table) {
            //
        });
    }
};
