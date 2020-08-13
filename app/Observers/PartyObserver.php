<?php

namespace App\Observers;

use App\Party;
use App\Events\PartyMap;

class PartyObserver
{
    private $st_created = 1;
    private $st_updated = 2;
    private $st_deleted = 0;
    /**
     * Handle the party "created" event.
     *
     * @param  \App\Party  $party
     * @return void
     */
    public function created(Party $party)
    {
        broadcast(new PartyMap($party, $this->st_created));
    }

    /**
     * Handle the party "updated" event.
     *
     * @param  \App\Party  $party
     * @return void
     */
    public function updated(Party $party)
    {
        broadcast(new PartyMap($party, $this->st_updated));
    }

    /**
     * Handle the party "deleted" event.
     *
     * @param  \App\Party  $party
     * @return void
     */
    public function deleted(Party $party)
    {
        broadcast(new PartyMap($party, $this->st_deleted));
    }

    /**
     * Handle the party "restored" event.
     *
     * @param  \App\Party  $party
     * @return void
     */
    public function restored(Party $party)
    {
        //
    }

    /**
     * Handle the party "force deleted" event.
     *
     * @param  \App\Party  $party
     * @return void
     */
    public function forceDeleted(Party $party)
    {
        //
    }
}
