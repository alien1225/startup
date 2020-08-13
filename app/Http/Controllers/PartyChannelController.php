<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
    	return response($user, 200);
    }
}
