<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrainingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trainings')->insertOrIgnore([
        	[
                'id'         => 1,   
                'user_id'    => 2,
                'brand_id'   => 1,
                'title'      => "Training 1",
                'slug'       => "training-1",
                'description'=> null,
                'start_date' => Carbon::now(),
                'end_date'   => Carbon::now(),
                'file'       => null,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'user_id'    => 2,
                'brand_id'   => 2,
                'title'      => "Training 2",
                'slug'       => "training-2",
                'description'=> null,
                'start_date' => Carbon::now(),
                'end_date'   => Carbon::now(),
                'file'       => null,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'user_id'    => 2,
                'brand_id'   => 3,
                'title'      => "Training 3",
                'slug'       => "training-3",
                'description'=> null,
                'start_date' => Carbon::now(),
                'end_date'   => Carbon::now(),
                'file'       => null,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}