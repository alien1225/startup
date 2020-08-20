<?php

namespace App;

use App\Events\JoinCreatorUserInYourParty;
use Illuminate\Database\Eloquent\Model;
use App\Events\PartyMap;
use App\Http\Resources\PartyResource;
use App\User;

class Party extends Model
{

    protected $guarded = [];
  
    

    public function scopePartyType($query, $model) {
        if ($model->visible != 1 && $model->password != 0) {
            return 3;
        }
        if ($model->password != 0) {
            return 2;
        }
        return 1;
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
