<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class HighRiskUsers implements Actionable
{
    public const TYPE_FREQUENCY = 1;

    public const TYPE_RANDOM = 2;

    public function __construct(protected int $count = 10)
    {
        //
    }

    public function do() : array
    {
        $users = User::query()
            ->select(["users.id as id", "users.name as name",
                "users.email as email", DB::raw("count(pii_access.id) as request_count")
            ])
            ->join("pii_access", "pii_access.user_id", "=", "users.id")
            ->join("requests", "requests.id", "=", "pii_access.request_id")
            ->where("pii_access.created_at", ">", now()->subDay()->startOfDay()->format(TIMESTAMP_STANDARD))
            ->groupBy("pii_access.request_id", "pii_access.user_id")
            ->orderBy("request_count", "DESC")
            ->limit($this->count)
            ->get();

        $users = $users->transform(function (User $user) {
            return [
                "id" => $user->id,
                "name" => $user->name,
                "email" => $user->email,
            ];
        });

        return $users->values()->toArray();
    }
}
