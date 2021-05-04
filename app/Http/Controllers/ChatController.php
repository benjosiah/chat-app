<?php

namespace App\Http\Controllers;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\Team;
use App\Models\Member;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Events\NewChatMessage;
use Inertia\Inertia;


class ChatController extends Controller
{

    public function dashboard(){
        return Inertia::render('Welcome', [
         
        ]);
    }
    public function chatRoom($team_id){
        $chatrooms = ChatRoom::where('team_id', $team_id)
            ->get();
        foreach($chatrooms as $chatroom){
            $chatroom->team;
        }
        $teams = Member::where('user_id', Auth::user()->id)
        ->orWhere('team_id',1)
        ->with('team')
        ->orderBy('created_at', 'DESC')
        ->get();
        // return $chatrooms;
        return Inertia::render('chat/ChatRoom',[
            'team_id'=>$team_id,
            'teams'=>$teams
        ]);

    }
    public function chatRooms($team_id){
        $chatrooms = ChatRoom::where('team_id', $team_id)
            ->get();
        foreach($chatrooms as $chatroom){
            $chatroom->team;
        }
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
        return $chatroom;
    }

    public function newMessage(Request $request, $chatroom_id){
        $message = new ChatMessage;
        $message->chat_room_id = $chatroom_id;
        $message->user_id = Auth::user()->id;
        $message->message = $request['message'];
        if($message->save()){
            broadcast(new NewChatMessage($message))->toOthers();
        }
        
        return $message;
    }

    public function newTeam(Request $request){
        $team = new Team;
        $team->name = $request['name'];
        if($team->save()){
            $member = new Member;
            $member->user_id = Auth::user()->id;
            $member->team_id = $team->id;
            $member->save();

            $chatroom = new chatRoom;
            $chatroom->name = "Random";
            $chatroom->team_id = $team->id;
            $chatroom->save();
            return $team;
        }
        
    }

    public function addMember(Request $request, $team_id){
        $user = User::where('email', $request['email'])->first();
        if ( !empty($user)) {
            $check = Member::where('user_id', $user->id)
            ->where('team_id', $team_id)
            ->first();
            if(empty($check)){
                $member = new Member;
                $member->user_id = $user->id;
                $member->team_id = $team_id;
                $member->save();
                return $member; 
            }
        }
       
        return;
        
    }

    public function Teams(){
        $teams = Member::where('user_id', Auth::user()->id)
        ->with('team')
        ->orderBy('created_at', 'DESC')
        ->get();
       return $teams;
    }

    public function getDashboard(){
        return Inertia::render('Dashboard'); 
    }

    
}
