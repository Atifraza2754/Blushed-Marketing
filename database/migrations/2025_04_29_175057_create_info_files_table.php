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
        Schema::create('info_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('info_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('created_by');
            $table->string('files')->nullable();
            $table->string('name')->nullable();
            $table->tinyInteger('is_deleted')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('info_files');
    }
};
