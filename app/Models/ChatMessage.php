<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;

    public function chatRoom(){
        return $this->belongsTo('App\Model\ChatRoom', 'chat_room_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User');
    }
}
