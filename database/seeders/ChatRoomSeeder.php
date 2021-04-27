<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChatRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $chatroom= [
            [
                'name'=>'Random',
                'team_id'=>1
            ],
            [
                'name'=>'Tech',
                'team_id'=>1
            ],
            [
                'name'=>'Sport',
                'team_id'=>1
            ],
            [
                'name'=>'Art',
                'team_id'=>1
            ],
        ];
        DB::table("chat_rooms")->insert($chatroom);
    }
}
