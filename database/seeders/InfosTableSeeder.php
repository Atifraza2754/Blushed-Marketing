<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InfosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('infos')->insertOrIgnore([
        	[
                'id'         => 1,   
                'user_id'    => 2,
                'brand_id'   => 1,
                'title'      => "Info 1",
                'slug'       => "info-1",
                'description'=> null,
                'file'       => null,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 2,   
                'user_id'    => 2,
                'brand_id'   => 2,
                'title'      => "Info 2",
                'slug'       => "info-2",
                'description'=> null,
                'file'       => null,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'id'         => 3,   
                'user_id'    => 2,
                'brand_id'   => 3,
                'title'      => "Info 3",
                'slug'       => "info-3",
                'description'=> null,
                'file'       => null,
                'status'     => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);

    }
}