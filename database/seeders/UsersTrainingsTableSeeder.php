<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTrainingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users_trainings')->insertOrIgnore([
        	[
                'id'         => 1,   
                'user_id'    => 5,
                'training_id'=> 1,
                'status'     => "pending",
                'due_date'   => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'user_id'    => 6,
                'training_id'=> 1,
                'status'     => "pending",
                'due_date'   => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'user_id'    => 7,
                'training_id'=> 1,
                'status'     => "complete",
                'due_date'   => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}