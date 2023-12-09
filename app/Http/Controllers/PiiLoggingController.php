<?php

namespace App\Http\Controllers;

use App\Http\Requests\External\AwbLogRequest;
use App\Http\Requests\External\LogRequest;
use App\Models\Models\Awb;
use App\Models\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PiiLoggingController extends APIController
{
    /**
     * Log the given request access instance.
     *
     * @param LogRequest $request
     * @return JsonResponse
     */
    public function log(LogRequest $request) : JsonResponse
    {
        try
        {
            $instance = Request::findWithURL($request->url);

            if ($instance != null)
            {
                $instance->logs()->create([
                    "user_id" => $request->userId,
                    "score" => $instance->score,
                    "meta" => $request->getMeta()
                ]);

                $response = $this->respondWithCreated([]);
            }
            else
            {
                $response = $this->respondWithNotFound([
                    "message" => "No request signature available for the given request."
                ]);
            }
        }
        catch (\Throwable $exception)
        {
            Log::error("PiiLoggingControllerLogException", [
                "message" => $exception->getMessage(),
                "trace" => $exception->getTrace()
            ]);

            $response = $this->respondWithServerError([
                "message" => "We ran into an error. Please try again in a while."
            ]);
        }

        return $response;
    }

    /**
     * Log the given Awb access instance.
     *
     * @param AwbLogRequest $request
     * @return JsonResponse
     */
    public function logAwb(AwbLogRequest $request) : JsonResponse
    {
        try
        {
            Awb::query()->create(
                $request->only("awb", "user_id")
            );

            return $this->respondWithOkay();
        }
        catch (\Throwable $exception)
        {
            Log::error("PiiLoggingControllerLogAwbException", [
                "message" => $exception->getMessage(),
                "trace" => $exception->getTrace()
            ]);

            return $this->respondWithServerError([
                "message" => "We ran into an error. Please try again in a while."
            ]);
        }
    }
}
