<?php

namespace App\Http\Controllers;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class ChatController extends Controller
{
    public function chatRooms(){
        $chatrooms = ChatRoom::all();
        return $chatrooms;
    }

    // public function chatRoom($chatromm_id){
    //     $chatromms = ChatRoom::where('id', $chatromm_id);
    // }

    public function messages($chatroom_id){
        $messages = ChatMessage::where('chat_room_id', $chatroom_id)->get();
        return $messages;
    }

    public function newMessage(Request $request, $chatroom_id){
        $message = new ChatMessage;
        $message->chat_room_id = $chatroom_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request['message'];
        $message->save();
        return $message;
    }

    
}