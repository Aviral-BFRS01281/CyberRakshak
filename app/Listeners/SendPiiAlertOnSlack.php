<?php

namespace App\Listeners;

use App\Events\PiiBreached;
use App\Models\Alert;

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
        sendSlackMultipleNotification(vsprintf("Alert triggered for %s", [Alert::NAMES[$event->getPayload()->type] ?? "N/A"]), "cybersafeview");
    }
}
