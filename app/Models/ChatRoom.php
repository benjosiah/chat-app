<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    use HasFactory;

    public function message(){
        return $this->hasMany('App\Models\ChatMessage');
    }

    public function team(){
        return $this->belongsTo('App\Models\Team', 'team_id');
    }
}
