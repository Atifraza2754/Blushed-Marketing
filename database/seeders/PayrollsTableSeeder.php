<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PayrollsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('payrolls')->insertOrIgnore([
        	[
                'id'         => 1,   
                'user_id'    => 5,
                'name'       => "Alex",
                'email_address'=> "email200@gmail.com",
                'address'    => "Address 1",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'user_id'    => 6,
                'name'       => "John",
                'email_address'=> "email201@gmail.com",
                'address'    => "Address 2",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

    }
}