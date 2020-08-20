<?php

use Illuminate\Support\Facades\Broadcast;
use App\User;
use App\Party;
use Illuminate\Support\Facades\Auth;
use App\Notifications\PartyNotification;


Broadcast::channel('map', function(User $user) {
	return Auth::check() ? true : false;
});

Broadcast::channel('party.{partyId}', function(User $user, $partyId) {	
	if ($user->userParty) {
		if ($user->userParty->id === (int)$partyId) {
			return $user;
		}
		$user->notify(new PartyNotification($user->userParty, 'event', 'Leave party - '.$user->userParty->name));
		return false;
	}
	$user->party_id = $partyId;
	$user->save();
	return $user;
});

Broadcast::channel('App.User.{userId}', function (User $user, $userId) {
    return (int) $user->id === (int) $userId;
});