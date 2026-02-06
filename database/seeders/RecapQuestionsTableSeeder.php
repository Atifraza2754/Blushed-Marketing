<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RecapQuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('recap_questions')->insertOrIgnore([
        	[
                'id'         => 1,   
                'recap_id'   => 1,
                'title'      => "Recap 1 Question 1",
                'description'=> null,
                'question_type' => "text",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'recap_id'   => 1,
                'title'      => "Recap 1 Question 2",
                'description'=> null,
                'question_type' => "textarea",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'recap_id'   => 1,
                'title'      => "Recap 1 Question 3",
                'description'=> null,
                'question_type' => "date",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 4,   
                'recap_id'   => 1,
                'title'      => "Recap 1 Question 4",
                'description'=> null,
                'question_type' => "select",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 5,   
                'recap_id'   => 1,
                'title'      => "Recap 1 Question 5",
                'description'=> null,
                'question_type' => "checkbox",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 6,   
                'recap_id'   => 1,
                'title'      => "Recap 1 Question 6",
                'description'=> null,
                'question_type' => "radio",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 7,   
                'recap_id'   => 1,
                'title'      => "Recap 1 Question 7",
                'description'=> null,
                'question_type' => "image",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 8,   
                'recap_id'   => 2,
                'title'      => "Recap 2 Question 1",
                'description'=> null,
                'question_type' => "text",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 9,   
                'recap_id'   => 2,
                'title'      => "Recap 2 Question 2",
                'description'=> null,
                'question_type' => "textarea",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 10,   
                'recap_id'   => 2,
                'title'      => "Recap 2 Question 3",
                'description'=> null,
                'question_type' => "radio",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 11,   
                'recap_id'   => 2,
                'title'      => "Recap 2 Question 4",
                'description'=> null,
                'question_type' => "select",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 12,   
                'recap_id'   => 2,
                'title'      => "Recap 2 Question 5",
                'description'=> null,
                'question_type' => "checkbox",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 13,   
                'recap_id'   => 3,
                'title'      => "Recap 3 Question 1",
                'description'=> null,
                'question_type' => "select",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 14,   
                'recap_id'   => 3,
                'title'      => "Recap 3 Question 2",
                'description'=> null,
                'question_type' => "checkbox",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 15,   
                'recap_id'   => 3,
                'title'      => "Recap 3 Question 3",
                'description'=> null,
                'question_type' => "text",
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);

    }
}