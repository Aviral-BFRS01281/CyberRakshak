<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;
use App\Models\Request;
use Illuminate\Support\Facades\DB;

class BreachedPIIScreens implements Actionable
{
    public function do() : array
    {
        $map = [];

        $requests = Request::query()
            ->select(["requests.id as id", "requests.url as url",
                "requests.url_hash as url_hash", DB::raw("sum(pii_access.score) as severity"),
                "requests.tag as tag"
            ])
            ->join("pii_access", "pii_access.user_id", "=", "requests.id")
            ->where("pii_access.created_at", ">", now()->subDay()->startOfDay()->format(TIMESTAMP_STANDARD))
            ->groupBy("requests.id")
            ->orderBy("severity", "DESC")
            ->limit(10)
            ->get();

        $requests = $requests->transform(function (Request $request) use (&$map) {
            return [
                "url" => $request->url,
                "severity" => $request->severity,
                "tag" => $request->tag
            ];
        });

        return $requests->values()->toArray();
    }
}
