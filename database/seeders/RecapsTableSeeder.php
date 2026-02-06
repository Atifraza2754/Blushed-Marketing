<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecapsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recaps')->insertOrIgnore([
        	[
                'id'         => 1,   
                'user_id'    => 2,
                'brand_id'   => 1,
                'title'      => "Recap 1",
                'description'=> null,
                'no_of_questions' => 5,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'user_id'    => 2,
                'brand_id'   => 2,
                'title'      => "Recap 2",
                'description'=> null,
                'no_of_questions' => 3,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'user_id'    => 2,
                'brand_id'   => 3,
                'title'      => "Recap 3",
                'description'=> null,
                'no_of_questions' => 1,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

    }
}