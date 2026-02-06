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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('role_id');

            $table->string('name');
            $table->string('email')->unique();
            $table->string('verification_code')->nullable();
            $table->boolean('is_email_verified')->default(false);
            $table->timestamp('email_verified_at')->nullable();

            $table->string('mobile_no',15)->nullable();
            $table->boolean('is_mobile_no_verified')->default(false);
            $table->timestamp('mobile_no_verified_at')->nullable();
            
            $table->string('profile_image')->nullable();
            $table->string('gender')->nullable();
            $table->date('date_of_birth')->nullable();
            
            $table->unsignedBigInteger('country_id')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('address',500)->nullable();

            $table->string('flat_rate')->nullable();

            $table->boolean('status')->default(true);

            $table->string('password');
            $table->rememberToken();

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
