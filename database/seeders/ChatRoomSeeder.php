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
                'name'=>'General',
            ],
            [
                'name'=>'Tech',
            ],
            [
                'name'=>'Design',
            ],
            [
                'name'=>'Art',
            ],
        ];
        DB::table("chat_rooms")->insert($chatroom);
    }
}
