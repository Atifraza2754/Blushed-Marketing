<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRecapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_recaps')->insertOrIgnore([
        	[
                'id'             => 1,   
                'user_id'        => 5,
                'recap_id'       => 1,
                'submit_date'    => null,
                'shift_date'     => null,
                'feedback'       => "You need more learning",
                'status'         => "submitted",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 2,   
                'user_id'        => 6,
                'recap_id'       => 1,
                'submit_date'    => null,
                'shift_date'     => null,
                'feedback'       => "You are good",
                'status'         => "submitted",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]
        ]);

    }
}