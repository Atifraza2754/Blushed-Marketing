<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserQuizzesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_quizzes')->insertOrIgnore([
        	[
                'id'             => 1,   
                'quiz_id'        => 1,
                'user_id'        => 5,
                'submit_date'    => null,
                'shift_date'     => null,
                'total_questions'=> 5,
                'attempted_questions' => 3,
                'right_answers'  => 1,
                'wrong_answers'  => 4,
                'feedback'       => "You need more learning",
                'status'         => "submitted",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 2,   
                'quiz_id'        => 1,
                'user_id'        => 6,
                'submit_date'    => null,
                'shift_date'     => null,
                'total_questions'=> 5,
                'attempted_questions' => 3,
                'right_answers'  => 4,
                'wrong_answers'  => 1,
                'feedback'       => "You are good",
                'status'         => "submitted",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 3,   
                'quiz_id'        => 1,
                'user_id'        => 7,
                'submit_date'    => null,
                'shift_date'     => null,
                'total_questions'=> 5,
                'attempted_questions' => 3,
                'right_answers'  => 2,
                'wrong_answers'  => 3,
                'feedback'       => "You need more learning",
                'status'         => "submitted",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]
        ]);

    }
}