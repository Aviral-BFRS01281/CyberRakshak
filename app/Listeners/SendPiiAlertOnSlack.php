<?php

namespace App\Listeners;

use App\Events\PiiBreached;

class SendPiiAlertOnSlack
{
    /**
     * Handle the event.
     *
     * @param PiiBreached $event
     * @return void
     */
    public function handle(PiiBreached $event)
    {
        //
    }
}
