<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams= [
            [
                'name'=>'General',
            ],
          
        ];
        DB::table("teams")->insert($teams);
    }
}
