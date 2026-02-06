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
        Schema::create('job_members_work_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('job_member_id')->default(null);
            $table->unsignedBigInteger('work_history_id')->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_members_work_history');
    }
};
