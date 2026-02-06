<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('notifications')->insertOrIgnore([
        	[
                'id'         => 1,   
                'user_id'    => 1,
                'title'      => "Recap Submitted",
                'description'=> "User 1 submitted his recap",
                'link'       => "user",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'user_id'    => 1,
                'title'      => "Quiz Submitted",
                'description'=> "User 1 submitted his quiz",
                'link'       => "link",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'user_id'    => 1,
                'title'      => "W9 Form Submitted",
                'description'=> "User 1 submitted his w9 form",
                'link'       => "link",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 4,   
                'user_id'    => 1,
                'title'      => "Payroll Form Submitted",
                'description'=> "User 1 submitted his payroll form",
                'link'       => "link",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 5,   
                'user_id'    => 5,
                'title'      => "Recap Approved",
                'description'=> "Admin has approved your recap",
                'link'       => "link",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 6,   
                'user_id'    => 5,
                'title'      => "Quiz Approved",
                'description'=> "Admin has approved your quiz",
                'link'       => "user",
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}