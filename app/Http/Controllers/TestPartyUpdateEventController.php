<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Party;


class TestPartyUpdateEventController extends Controller
{
    public function update() {
    	$party = Party::find(3);
    	$party->name = "T".$party->name;
    	$party->save();
    }
    public function delete() {
    	$party = Party::find(3);
    	$party->delete();
    	
    }
}
