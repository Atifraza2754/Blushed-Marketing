<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class W9formsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('w9forms')->insertOrIgnore([
        	[
                'id'         => 1,
                'user_id'    => 5,
                'name'       => "Alex",
                'business_name' => "Business 1",
                'address'    => "Address 1",
                'date'       => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,
                'user_id'    => 6,
                'name'       => "John",
                'business_name'=> "Business 2",
                'address'    => "Address 2",
                'date'       => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,
                'user_id'    => 7,
                'name'       => "Saim",
                'business_name'=> "Business 3",
                'address'    => "Address 3",
                'date'       => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}
