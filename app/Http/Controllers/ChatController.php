<?php

namespace App\Http\Controllers;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;


class ChatController extends Controller
{
    public function chatRooms($team_id){
        $chatrooms = ChatRoom::where('team_id', $team_id);
        return $chatrooms;
    }

    // public function chatRoom($chatromm_id){
    //     $chatromms = ChatRoom::where('id', $chatromm_id);
    // }

    public function messages($chatroom_id){
        $messages = ChatMessage::where('chat_room_id', $chatroom_id)
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->get();
        return $messages;
    }

    public function newChatRoom(Request $request, $team_id){
        $chatroom = new chatRoom;
        $chatroom->name = $request['name'];
        $chatroom->team_id = $team_id;
        $chatroom->save();
        // broadcast(new NewChatMessage($message))->toOthers();
        return $message;
    }

    public function newMessage(Request $request, $chatroom_id){
        $message = new ChatMessage;
        $message->chat_room_id = $chatroom_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request['message'];
        $message->save();
        broadcast(new NewChatMessage($message))->toOthers();
        return $message;
    }

    public function newTeam(Request $request){
        $team = new Team;
        $team->name = $request['name'];
        if($team->save()){
            $member = new Member;
            $member->user_id = Auth::user()->id;
            $member->team_id = $team->id;
            return $team;
        }
        
    }

    public function addMemer(Request $request, $team_id){
        $user = User::where('email', $request['email'])->first();
        $member = new Member;
        $member->user_id = $user->id;
        $member->team_id = $team_id;
        return $member;   
    }

    public function userTeam(Request $request){
        $teams = Member::where('user', Auth::user()->id)
        ->with('team')
        ->orderBy('created_at', 'DESC')
        ->get();
        return $teams;   
    }
    
}
