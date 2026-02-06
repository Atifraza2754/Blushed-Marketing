<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_settings')->insertOrIgnore([
        	[
                'id'        => 1,
                'site_name' => 'Blushed',
                'site_publisher' => 'Ubba Soft',
            ],
        ]);

    }
}