<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Party;
use App\Http\Resources\PartyResource;

class PartyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index() {
        return PartyResource::collection(Party::where('visible', '=', 1)->get());
    }

    public function create(Request $request) {
    	$data = $request->validate([
            'name' => "required|string|max:255",
            'max_users' => "required|int|max:10",
            'coords.*' => "required"
        ]);

        $newParty = Auth::user()->userParties()->create([
            'name' => $data['name'],
            'max_users' => $data['max_users'],
            'description' => 'ghthytjtjytj',
            'coords' => $data['coords']['lat']."|". $data['coords']['lng']
        ]);
    }

    public function party(Party $partyId) {
        if (Auth::user()->userParty && Auth::user()->userParty->id == $partyId->id) {
            return response($partyId, 200);
        }
    }
}


