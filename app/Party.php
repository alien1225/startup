<?php

namespace App;

use App\Events\JoinCreatorUserInYourParty;
use Illuminate\Database\Eloquent\Model;
use App\Events\PartyMap;

class Party extends Model
{
    protected $guarded = [];
    

    public function scopePartiesVisible($query, int $status) {
        return $query->where('visible', $status);
    }

    public function partyOwner() 
    {
        return $this->belongsTo(\App\User::class, "user_id");
    }

    public function partyUsers() 
    {
        return $this->hasMany(\App\User::class);
    }
}
