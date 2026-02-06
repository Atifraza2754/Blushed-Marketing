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
        Schema::create('work_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(null);
            $table->unsignedBigInteger('job_id')->default(null);
            $table->timestamp('date')->nullable();
            $table->longText('image')->default(null);
            $table->integer('shift_hours')->default(null);
            $table->time('user_working_hour')->default(null);
            $table->tinyInteger('falt_rate')->default(null);
            $table->time('check_in')->default(null);
            $table->time('check_out')->default(null);
            $table->integer('lat')->default(null);
            $table->integer('lon')->default(null);
            $table->tinyInteger('is_active_shift')->default(null);
            $table->tinyInteger('is_confirm')->default(null);
            $table->tinyInteger('is_complete')->default(null);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_history');
    }
};
