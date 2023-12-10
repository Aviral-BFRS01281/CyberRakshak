<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;

class DormantUsers implements Actionable
{
    public function do() : array
    {
        $stats = getInternalUserStatistics();

        return [
            [
                "name" => "Not Logged In",
                "text" => "(since last 30 days)",
                "value" => 5,
                "type" => "number"
            ],
            [
                "name" => "Logged In",
                "text" => "(after 30 days)",
//                "value" => $stats["last_30_days_inactive"] ?? 0,
                "value" => 10,
                "type" => "number"
            ],
            [
                "name" => "Viewed PII Details",
                "text" => null,
                "value" => dormantPiiIncidentsInLast30Days(),
                "type" => "number"
            ]
        ];
    }
}
