<?php

namespace App\Http\Resources\Internal\Users\Analytics;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Cache;

class BehaviourResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "risk_analytics" => $this->riskAnalytics(),
            "access" => $this->access(),
            "hot_urls" => $this->hot_urls(),
            "journey_map" => $this->journey_map()
        ];
    }

    public function riskAnalytics()
    {
        return Cache::remember(vsprintf("%d_behaviour_analytics", [$this->id]), 60 * 60, function () {
            return getUserRiskHistory($this->id);
        });
    }

    public function access() : array
    {
        return [
            "working_hours" => 0,
            "non_working_hours" => 0
        ];
    }

    public function hot_urls() : URLCollection
    {
        return new URLCollection($this->hotURLs);
    }

    public function journey_map()
    {
        return getUserJourneyMap($this->id);
    }
}
