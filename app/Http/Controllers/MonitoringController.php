<?php

namespace App\Http\Controllers;

use App\Http\Requests\External\LogRequest;
use App\Models\RequestPii;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class MonitoringController extends APIController
{
    /**
     * @param LogRequest $request
     * @return JsonResponse
     */
    public function log(LogRequest $request) : JsonResponse
    {
        try
        {
            $instance = RequestPii::findWithURL($request->url);

            $instance->logs()->create([
                "user_id" => $request->userId,
                "pii_score" => 0,
                "meta" => $request->meta
            ]);
        }
        catch (ValidationException $exception)
        {

        }
        catch (\Throwable $exception)
        {

        }
    }
}
