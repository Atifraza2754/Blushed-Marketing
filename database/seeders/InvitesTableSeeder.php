<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InvitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('invites')->insertOrIgnore([
        	[
                'id'         => 1,   
                'invited_by' => 1,
                'role_id'    => 2,
                'email'      => "admin2@gmail.com",
                'has_signup' => false,
                'status'     => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'invited_by' => 1,
                'role_id'    => 3,
                'email'      => "recruiter2@gmail.com",
                'has_signup' => false,
                'status'     => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'invited_by' => 1,
                'role_id'    => 4,
                'email'      => "accounter2@gmail.com",
                'has_signup' => false,
                'status'     => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 4,   
                'invited_by' => 2,
                'role_id'    => 5,
                'email'      => "user2@gmail.com",
                'has_signup' => false,
                'status'     => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],

        ]);

    }
}