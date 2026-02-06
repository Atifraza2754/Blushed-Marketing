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
        Schema::create('brands', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('description', 500)->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_quiz_uploaded')->default(false);
            $table->boolean('is_recap_uploaded')->default(false);
            $table->boolean('is_training_uploaded')->default(false);
            $table->boolean('is_info_uploaded')->default(false);
            $table->boolean('status')->default(true);
            $table->boolean('featured')->default(false);

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
        Schema::dropIfExists('brands');
    }
};
