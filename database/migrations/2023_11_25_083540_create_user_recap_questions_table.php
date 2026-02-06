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
        Schema::create('user_recap_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_recap_id');

            $table->string('recap_question_type');
            $table->string('recap_question');
            $table->string('recap_question_options')->nullable();
            $table->text('recap_question_answer')->nullable();

            $table->timestamps();
            $table->foreign('user_recap_id')->references('id')->on('user_recaps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_recap_questions');
    }
};
