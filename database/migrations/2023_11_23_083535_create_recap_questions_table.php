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
        Schema::create('recap_questions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('recap_id');

            $table->string('title');
            $table->string('description', 500)->nullable();
            $table->string('question_type')->nullable();
            $table->text('options')->nullable();
            $table->boolean('status')->default(true);

            $table->timestamps();
            $table->softDeletes();
            $table->foreign('recap_id')->references('id')->on('recaps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recap_questions');
    }
};
