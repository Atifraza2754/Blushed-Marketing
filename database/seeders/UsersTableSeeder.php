<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insertOrIgnore([
        	[
                'id'            => 1,   
                'name'          => "Super Admin",
                'role_id'       => 1,
                'email'         => "admin@gmail.com",
                'password'      => bcrypt("12345678"),
                'mobile_no'     => "12345678",
                'gender'        => "male",
                'date_of_birth' => "1990-01-01",
                'status'        => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 2,   
                'name'          => "Admin 1",
                'role_id'       => 2,
                'email'         => "admin1@gmail.com",
                'password'      => bcrypt("12345678"),
                'mobile_no'     => "12345672",
                'gender'        => "male",
                'date_of_birth' => "1994-01-01",
                'status'        => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 3,   
                'name'          => "Recruiter 1",
                'role_id'       => 3,
                'email'         => "recruiter1@gmail.com",
                'password'      => bcrypt("12345678"),
                'mobile_no'     => "123456724",
                'gender'        => "male",
                'date_of_birth' => "1996-01-01",
                'status'        => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 4,   
                'name'          => "Accounter 1",
                'role_id'       => 4,
                'email'         => "accounter1@gmail.com",
                'password'      => bcrypt("12345678"),
                'mobile_no'     => "123456724",
                'gender'        => "male",
                'date_of_birth' => "1996-01-01",
                'status'        => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 5,   
                'name'          => "User 1",
                'role_id'       => 5,
                'email'         => "user1@gmail.com",
                'password'      => bcrypt("12345678"),
                'mobile_no'     => "123456724",
                'gender'        => "male",
                'date_of_birth' => "1996-01-01",
                'status'        => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 6,   
                'name'          => "User 2",
                'role_id'       => 5,
                'email'         => "user2@gmail.com",
                'password'      => bcrypt("12345678"),
                'mobile_no'     => "123456702",
                'gender'        => "male",
                'date_of_birth' => "1996-01-01",
                'status'        => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ],
            [
                'id'            => 7,   
                'name'          => "User 3",
                'role_id'       => 5,
                'email'         => "user3@gmail.com",
                'password'      => bcrypt("12345678"),
                'mobile_no'     => "123456703",
                'gender'        => "male",
                'date_of_birth' => "1996-01-01",
                'status'        => 1,
                'created_at'    => Carbon::now(),
                'updated_at'    => Carbon::now(),
            ]
        ]);

    }
}