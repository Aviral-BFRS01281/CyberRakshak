<?php

namespace App\Listeners;

use App\Events\PiiBreached;
use App\Models\Alert;

class CreatePiiDashboardAlert
{
    /**
     * Handle the event.
     *
     * @param PiiBreached $event
     * @return bool
     */
    public function handle(PiiBreached $event) : bool
    {
        $payload = $event->getPayload();

        $lastTriggered = Alert::query()
            ->where("user_id", $payload->userId)
            ->where("type", $payload->type)
            ->where("created_at", ">", past())
            ->first();

        $next = true;

        if ($lastTriggered != null)
        {
            $lastAccessed = abs(now()->diffInMinutes($lastTriggered->created_at));

            if ($lastAccessed > 10 || !$lastTriggered->action_taken)
            {
                Alert::query()->create([
                    "user_id" => $payload->userId,
                    "type" => $payload->type,
                    "trigger_value" => $payload->value,
                ]);
            }
            else
            {
                $next = false;
            }
        }
        else
        {
            Alert::query()->create([
                "user_id" => $payload->userId,
                "type" => $payload->type,
                "trigger_value" => $payload->value,
            ]);
        }

        return $next;
    }
}
