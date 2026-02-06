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
        Schema::create('user_payment_job_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->default(null);
            $table->unsignedBigInteger('job_id')->default(null);
            $table->tinyInteger('flat_rate')->default(0);
            $table->tinyInteger('is_payable')->default(0);
            $table->integer('is_paid')->default(null);
            $table->integer('date')->default(null);
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_payment_job_history');
    }
};
