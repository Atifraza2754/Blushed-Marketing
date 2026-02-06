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
        Schema::create('flat_rate_deduction', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('job_id');
            $table->string('name')->nullable();
            $table->date('job_date')->nullable();
            $table->date('deduction_date')->nullable();
            $table->string('flat_rate')->nullable();
            $table->string('deduction_amount')->nullable();
            $table->string('flat_rate_after_deduction')->nullable();
            $table->string('total_deduction')->nullable();
            $table->tinyInteger('paid_to_user')->nullable();

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flat_rate_deduction');
    }
};
