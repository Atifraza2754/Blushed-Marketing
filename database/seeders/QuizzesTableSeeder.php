<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizzesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quizzes')->insertOrIgnore([
        	[
                'id'         => 1,   
                'user_id'    => 2,
                'brand_id'   => 1,
                'title'      => "Quiz 1",
                'description'=> null,
                'image'      => null,
                'no_of_questions' => 5,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'user_id'    => 2,
                'brand_id'   => 2,
                'title'      => "Quiz 2",
                'description'=> null,
                'image'      => null,
                'no_of_questions' => 3,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'user_id'    => 2,
                'brand_id'   => 3,
                'title'      => "Quiz 3",
                'description'=> null,
                'image'      => null,
                'no_of_questions' => 1,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

    }
}