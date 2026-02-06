<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuizQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('quiz_questions')->insertOrIgnore([
        	[
                'id'         => 1,   
                'quiz_id'    => 1,
                'title'      => "Quiz 1 Question 1",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 1",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'quiz_id'    => 1,
                'title'      => "Quiz 1 Question 2",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 2",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'quiz_id'    => 1,
                'title'      => "Quiz 1 Question 3",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 3",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 4,   
                'quiz_id'    => 1,
                'title'      => "Quiz 1 Question 4",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 4",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 5,   
                'quiz_id'    => 1,
                'title'      => "Quiz 1 Question 5",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 1",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 6,   
                'quiz_id'    => 2,
                'title'      => "Quiz 2 Question 1",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 1",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 7,   
                'quiz_id'    => 2,
                'title'      => "Quiz 2 Question 2",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 2",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 8,   
                'quiz_id'    => 2,
                'title'      => "Quiz 2 Question 3",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 3",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 9,   
                'quiz_id'    => 3,
                'title'      => "Quiz 3 Question-1",
                'description'=> null,
                'image'      => null,
                'answer'     => "option 1",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);

    }
}