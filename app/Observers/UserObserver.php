<?php

namespace App\Observers;

use App\User;
use App\Party;
use App\Observers\Observer;
use App\Events\PartyMap;

class UserObserver extends Observer
{

    private $userUntilUpdated;
    /**
     * Handle the user "created" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    public function updating(User $user) {
        //broadcast(new PartyMap(Party::find($user->party_id), $this->st_updated));
        $this->userUntilUpdated = $user;
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function saved(User $user)
    {
        $party = (int) $user->party_id !== (int) 0 ? Party::find($user->party_id) : Party::find($this->userUntilUpdated->party_id);
        broadcast(new PartyMap($party, $this->st_updated));
        unset($this->userUntilUpdated);
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
