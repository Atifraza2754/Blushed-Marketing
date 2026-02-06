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
        Schema::create('w9forms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('name');
            $table->string('business_name')->nullable();
            $table->string('federal_tax_classification')->nullable();
            $table->string('exempt_payee_code')->nullable();
            $table->string('fatca_reporting_code')->nullable();
            $table->string('address', 500)->nullable();
            $table->string('city_state_zipcode')->nullable();
            $table->string('account_number')->nullable();
            $table->string('requester_name')->nullable();
            $table->string('social_security_number')->nullable();
            $table->string('employer_identification_number')->nullable();
            $table->string('date')->nullable();
            $table->string('digital_signature')->nullable();

            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('w9forms');
    }
};
