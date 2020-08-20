<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PartyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name_party' => $this->name,
            'description' => $this->description,
            'type' => $this->partyType($this),
            'max_users' => $this->max_users,
            'coords' => $this->coords,
            'users' => $this->when(count($this->partyUsers), UserResource::collection($this->partyUsers)),
            'owner' => $this->partyOwner->id,
        ];
    }
}
