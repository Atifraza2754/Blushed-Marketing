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
        Schema::table('user_recap_questions', function (Blueprint $table) {
            $table->bigInteger('recap_question_id')->nullable()->after('id');
            $table->longText('answer')->nullable()->after('recap_question');


         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_recap_questions', function (Blueprint $table) {
            //
        });
    }
};
