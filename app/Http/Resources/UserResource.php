<?php

namespace App\Http\Resources;

use App\Http\Resources\PartyResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{


    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_user' => $this->name,
            'email' => $this->email,
            'party' => $this->when($this->party_id, $this->party_id),
        ];
    }

}
