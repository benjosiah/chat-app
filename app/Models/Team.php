<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    public function chatRoom(){
        return $this->hasMany('App\Models\ChatRoom');
    }

}
