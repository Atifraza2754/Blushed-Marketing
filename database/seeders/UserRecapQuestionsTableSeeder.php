<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserRecapQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('user_recap_questions')->insertOrIgnore([
        	[
                'id'             => 1,   
                'user_recap_id'  => 1,
                'recap_question_id'=> 1,
                'answer'         => "text 1",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 2,   
                'user_recap_id'  => 1,
                'recap_question_id'=> 2,
                'answer'         => "textarea 1",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 3,   
                'user_recap_id'  => 1,
                'recap_question_id'=> 3,
                'answer'         => '11-02-2023',
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 4,   
                'user_recap_id'  => 1,
                'recap_question_id'=> 4,
                'answer'         => "option 1",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 5,   
                'user_recap_id'  => 1,
                'recap_question_id'=> 5,
                'answer'         => "box 1",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 6,   
                'user_recap_id'  => 1,
                'recap_question_id'=> 6,
                'answer'         => "radio 1",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 7,   
                'user_recap_id'  => 1,
                'recap_question_id'=> 7,
                'answer'         => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 8,   
                'user_recap_id'  => 2,
                'recap_question_id'=> 1,
                'answer'         => "text 2",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 9,   
                'user_recap_id'  => 2,
                'recap_question_id'=> 2,
                'answer'         => "textarea 2",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 10,   
                'user_recap_id'  => 2,
                'recap_question_id'=> 3,
                'answer'         => "02-02-2023",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 11,   
                'user_recap_id'  => 2,
                'recap_question_id'=> 4,
                'answer'         => "option 2",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 12,   
                'user_recap_id'  => 2,
                'recap_question_id'=> 5,
                'answer'         => "box 2",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 13,   
                'user_recap_id'  => 2,
                'recap_question_id'=> 6,
                'answer'         => "radio 2",
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ],
            [
                'id'             => 14,   
                'user_recap_id'  => 2,
                'recap_question_id'=> 7,
                'answer'         => null,
                'created_at'     => Carbon::now(),
                'updated_at'     => Carbon::now(),
            ]
        ]);

    }
}