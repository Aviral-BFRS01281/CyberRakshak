<?php

namespace App\Http\Controllers;

use App\Http\Resources\Internal\Users\Analytics\BehaviourResource;
use App\Http\Resources\NullResource;
use App\Models\User;

class BehaviourAnalyticsController extends APIController
{
    public function show(int $id) : BehaviourResource|NullResource
    {
        $user = User::query()->with(["hotURLs"])->find($id);

        if ($user == null)
        {
            return new NullResource("user");
        }
        else
        {
            return new BehaviourResource($user);
        }
    }
}
