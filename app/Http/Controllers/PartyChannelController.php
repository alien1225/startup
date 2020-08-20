<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Events\Party\PartyChatMessage;


class PartyChannelController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function leaveChannel() 
    {
    	$user = Auth::user();
    	$user->party_id = 0;
    	$user->save();
    	return new UserResource($user);
    }

    public function sendMessageChat() {

        $message = request()->validate([
            'message' => "required",
            'party' => 'required',
        ]);

        broadcast(new PartyChatMessage(Auth::user(), 'hthtrjy'));
    }
}
