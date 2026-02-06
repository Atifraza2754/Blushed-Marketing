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
        Schema::create('user_quiz_reattempt', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quiz_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_quiz_id');

            $table->timestamp('submit_date')->nullable();
            $table->timestamp('shift_date')->nullable();
            $table->string('total_questions')->nullable();
            $table->text('all_answers')->nullable();
            $table->string('attempted_questions')->nullable();
            $table->string('right_answers')->nullable();
            $table->string('wrong_answers')->nullable();
            $table->text('feedback')->nullable();
            $table->string('status')->default('submitted');

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_quiz_reattempt');
    }
};
