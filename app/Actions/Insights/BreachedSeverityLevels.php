<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BreachedSeverityLevels implements Actionable
{
    const LOW = "low";

    const MEDIUM = "medium";

    const HIGH = "high";

    public function do() : array
    {
        $map = [
            self::LOW => ["severity" => self::LOW, "value" => 0],
            self::MEDIUM => ["severity" => self::MEDIUM, "value" => 0],
            self::HIGH => ["severity" => self::HIGH, "value" => 0],
        ];

        $users = User::query()
            ->select(["users.id as id", "users.name as name",
                "users.email as email", DB::raw("sum(pii_access.score) as severity")
            ])
            ->join("pii_access", "pii_access.user_id", "=", "users.id")
            ->join("requests", "requests.id", "=", "pii_access.request_id")
            ->where("pii_access.created_at", ">", now()->subDay()->startOfDay()->format(TIMESTAMP_STANDARD))
            ->groupBy("pii_access.user_id")
            ->get();

        $users->each(function (User $user) use (&$map) {
            if ($user->severity < 100)
            {
                $map[self::LOW]["value"]++;
            }
            elseif ($user->severity > 100 && $user->severity <= 500)
            {
                $map[self::MEDIUM]["value"]++;
            }
            else
            {
                $map[self::HIGH]["value"]++;
            }
        });

        return array_values($map);
    }
}
