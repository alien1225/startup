<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PartyController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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

}
