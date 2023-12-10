<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BreachedPIIDepartments implements Actionable
{
    public function __construct(protected int $count = 10)
    {
        //
    }

    public function do() : array
    {
        $map = [];

        $users = User::query()
            ->with("roles")
            ->select(["users.id as id", "users.name as name",
                "users.email as email", DB::raw("sum(pii_access.score) as severity")
            ])
            ->join("pii_access", "pii_access.user_id", "=", "users.id")
            ->join("requests", "requests.id", "=", "pii_access.request_id")
            ->where("pii_access.created_at", ">", now()->subDays(30)->startOfDay()->format(TIMESTAMP_STANDARD))
            ->groupBy("pii_access.user_id")
            ->orderBy("severity", "DESC")
            ->limit(10)
            ->get();

        $users->each(function (User $user) use (&$map) {
            $role = $user->roles->first();

            if ($role != null)
            {
                $key = $role->key;
                if (!isset($map[$key]))
                {
                    $map[$key] = [
                        "name" => $role->name,
                        "key" => $key,
                        "severity" => $user->severity
                    ];
                }
                else
                {
                    $map[$key]["severity"] += $user->severity;
                }
            }
        });

        return array_values($map);
    }
}
