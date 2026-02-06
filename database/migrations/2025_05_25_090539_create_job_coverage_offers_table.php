<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobCoverageOffersTable extends Migration
{
    public function up()
    {
        Schema::create('job_coverage_offers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('coverage_request_id'); // Links to job_coverage_requests.id
            $table->unsignedBigInteger('user_id');             // User offering to cover
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('job_coverage_offers');
    }
}
