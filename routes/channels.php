<?php

use Illuminate\Support\Facades\Broadcast;
use App\User;
use App\Party;
use Illuminate\Support\Facades\Auth;
/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('map', function(User $user) {
	return Party::where('visible', '=', 1)->get();
});

Broadcast::channel('party.{partyId}', function(User $user, $partyId) {

	if ($user->userParty && $user->userParty->id === (int)$partyId) {
		return $user;
	}

	$user->party_id = $partyId;
	$user->save();
	return $user;

});
