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
        Schema::create('jobs_c', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->date('date');
            $table->string('account')->nullable();
            $table->string('address')->nullable();
            $table->string('contact')->nullable();
            $table->string('phone')->nullable();
            $table->string('scheduled_time')->nullable();
            $table->string('timezone')->nullable();
            $table->string('email')->nullable();
            $table->string('method_of_communication')->nullable();
            $table->string('brand')->nullable();
            $table->string('skus')->nullable();

            $table->boolean('samples_requested')->default(false);
            $table->boolean('reschedule')->default(false);
            $table->boolean('added_to_homebase')->default(false);
            $table->boolean('confirmed')->default(false);

            $table->boolean('is_published')->default(false);

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
        Schema::dropIfExists('jobs_c');
    }
};
