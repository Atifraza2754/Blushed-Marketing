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
        Schema::create('job_coverage_requests', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('job_id');          // The shift or job needing coverage
            $table->unsignedBigInteger('requestor_id');    // Who requested the coverage
            $table->unsignedBigInteger('coverage_user_id')->nullable(); // Who is offering to cover (if any)
            $table->enum('type', ['unable', 'can_if_needed']); // Type of request
            $table->enum('status', ['pending', 'approved', 'declined'])->default('pending');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_coverage_requests');
    }
};
