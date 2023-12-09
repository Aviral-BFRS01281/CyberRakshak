<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;

class ActiveUsers implements Actionable
{
    public function do() : array
    {
        return [
            [
                "name" => "Admin",
                "text" => null,
                "value" => getInternalUserStatistics()["active_user_count"] ?? 0,
                "type" => "number"
            ],
        ];
    }
}
