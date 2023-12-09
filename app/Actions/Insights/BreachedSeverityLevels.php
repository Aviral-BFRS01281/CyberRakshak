<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;

class BreachedSeverityLevels implements Actionable
{
    const LOW = "low";

    const MEDIUM = "medium";

    const HIGH = "high";

    public function do() : array
    {
        return [
            self::LOW => [
                "incidents" => 3,
                "severe" => 2
            ],
            self::MEDIUM => [
                "incidents" => 3,
                "severe" => 2
            ],
            self::HIGH => [
                "incidents" => 3,
                "severe" => 2
            ]
        ];
    }
}
