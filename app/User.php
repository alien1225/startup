<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use App\Events\PartyMap;

class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = [];

    public function userParties() {
        return $this->hasMany(\App\Party::class);
    }

    public function userParty() {
        return $this->belongsTo(\App\Party::class, "party_id");
    }
}
