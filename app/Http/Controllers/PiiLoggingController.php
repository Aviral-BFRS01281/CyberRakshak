<?php

namespace App\Http\Controllers;

use App\Events\PiiBreached;
use App\Http\Requests\External\AwbLogRequest;
use App\Http\Requests\External\LogRequest;
use App\Models\Alert;
use App\Models\Awb;
use App\Models\Request;
use App\Models\User;
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
            $payload = $request->all();

            $fingerprint = sha1(implode('|',
                [$payload["verb"], $payload["url"], implode("|", $payload["params"])]
            ));

            $instance = Request::findWithHash($fingerprint);

            if ($instance != null)
            {
                $instance->logs()->create([
                    "request_id" => $instance->id,
                    "user_id" => $request->user_id,
                    "score" => $instance->score,
                    "meta" => json_encode($request->getMeta())
                ]);

                $payload = (object)[
                    "userId" => $request->user_id,
                    "type" => Alert::TYPE_PII,
                    "value" => 1
                ];

                event(
                    new PiiBreached($payload)
                );

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
            /**
             * @var $awb Awb
             * @var $user User
             */
            $awb = Awb::findByAwb($request->awb)->first();

            if ($awb == null)
            {
                $awb = Awb::query()->create([
                    "awb" => $request->awb
                ]);
            }

            $user = User::query()->find($request->userId);

            if ($user == null)
            {
                $response = getUserDetails([$request->userId]);

                $userDetails = [
                    "name" => $response["name"],
                    "email" => $response["email"],
                    "mobile" => $response["mobile"],
                    "last_active" => now()->format(TIMESTAMP_STANDARD)
                ];

                $user = User::query()->create($userDetails);
            }

            $user->awbs()->attach($awb);

            $payload = (object)[
                "userId" => $user->id,
                "type" => Alert::TYPE_PII
            ];

            event(
                new PiiBreached($payload)
            );

            return $this->respondWithCreated([]);
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
