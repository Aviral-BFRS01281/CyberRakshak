<?php

namespace App\Http\Controllers;

use App\Actions\Insights\ActiveUsers;
use App\Actions\Insights\BreachedPIIDepartments;
use App\Actions\Insights\BreachedPIIScreens;
use App\Actions\Insights\BreachedSeverityLevels;
use App\Actions\Insights\DormantUsers;
use App\Actions\Insights\HighRiskUsers;
use Illuminate\Http\JsonResponse;

class InsightsController extends APIController
{
    public function show() : JsonResponse
    {
        $stats = [
            "highRiskUsers" => (new HighRiskUsers(10))->do(),
            "breachedLevels" => (new BreachedSeverityLevels())->do(),
            "piiDepartments" => (new BreachedPIIDepartments())->do(),
            "piiScreens" => (new BreachedPIIScreens())->do(),
            "dormantUsers" => (new DormantUsers())->do(),
            "activeUsers" => (new ActiveUsers())->do()
        ];

        return $this->respondWithOkay(
            $stats
        );
    }
}
