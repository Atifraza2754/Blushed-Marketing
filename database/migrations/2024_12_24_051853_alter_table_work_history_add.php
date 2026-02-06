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
        Schema::table('work_history', function (Blueprint $table) {
            $table->float('mileage',6,2)->default(0)->after('is_complete');
            $table->float('sale_incentive',6,2)->default(0)->after('mileage');
            $table->float('out_of_pocket_expense',6,2)->default(0)->after('sale_incentive');
            $table->float('deduction',6,2)->default(0)->after('out_of_pocket_expense');
            $table->float('total_paid',6,2)->default(0)->after('deduction');
            $table->float('total_due',6,2)->default(0)->after('total_paid');
            $table->float('grand_total',6,2)->default(0)->after('total_due');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('work_history', function (Blueprint $table) {
            //
        });
    }
};
