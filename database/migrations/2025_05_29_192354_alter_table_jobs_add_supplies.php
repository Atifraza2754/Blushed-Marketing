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

            $table->string('how_to_serve')->nullable()->after('notes');
            $table->string('supplies_needed')->nullable()->after('how_to_serve');
            $table->string('attire')->nullable()->after('supplies_needed');
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
