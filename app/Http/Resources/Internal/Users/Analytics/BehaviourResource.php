<?php

namespace App\Http\Resources\Internal\Users\Analytics;

use Illuminate\Http\Resources\Json\JsonResource;

class BehaviourResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "risk_analytics" => [

            ],
            "access" => [
                "working_hours" => 0,
                "non_working_hours" => 0
            ],
            "hot_urls" => new URLCollection($this->hotURLs),
            "most_downloaded" => [
                "Order Download Report",
                "AWB Order Report",
                "Seller Order Report",
                "Churn Report"
            ]
        ];
    }
}
