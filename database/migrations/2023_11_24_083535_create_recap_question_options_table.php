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
        Schema::create('recap_question_options', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recap_question_id');

            $table->string('option');
            $table->string('type');
            $table->string('description', 500)->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('recap_question_id')->references('id')->on('recap_questions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recap_question_options');
    }
};
