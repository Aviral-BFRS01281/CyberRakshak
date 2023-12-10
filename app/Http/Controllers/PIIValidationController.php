<?php

namespace App\Http\Controllers;

use App\Actions\AnalyzePayload;
use App\Http\Requests\External\CheckRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class PIIValidationController extends APIController
{
    /**
     * Checks whether the give data contains any PII.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function check(CheckRequest $request) : JsonResponse
    {
        try
        {
            $payload = $request->all();

            $instance = new AnalyzePayload($payload["body"], piiFieldMap());

            $score = $instance->do();

            if ($score > 0)
            {
                $fingerprint = sha1(implode('|',
                    [$payload["verb"], $payload["url"], implode("|", $payload["params"])]
                ));

                $entry = \App\Models\Request::findWithHash($fingerprint);

                if ($entry == null)
                {
                    \App\Models\Request::query()->create([
                        "url" => $payload["url"],
                        "url_hash" => $fingerprint,
                        "score" => $score
                    ]);
                }

                $response = $this->respondWithCreated([
                    "message" => "Some PII was detected in the payload.",
                    "score" => $score,
                    "detected" => $instance->getDetectedFields()
                ]);
            }
            else
            {
                $response = $this->respondWithOkay([
                    "message" => "No PII was found in the payload.",
                    "score" => $score,
                    "detected" => []
                ]);
            }
        }
        catch (Throwable $throwable)
        {
            Log::info("PIIValidationCheckException", [
                "message" => $throwable->getMessage(),
                "trace" => $throwable->getTrace()
            ]);

            $response = $this->respondWithServerError([
                "message" => "We ran into an error. Please try again in a while."
            ]);
        }
        finally
        {
            return $response;
        }
    }
}
