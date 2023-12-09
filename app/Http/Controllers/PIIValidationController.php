<?php

namespace App\Http\Controllers;

use App\Actions\AnalyzePayload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Request as Requests;
use Throwable;

class PIIValidationController extends APIController
{
    /**
     * Checks whether the give data contains any PII.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function check(Request $request) : JsonResponse
    {
        try
        {
            $payload = $request->all();

            $instance = new AnalyzePayload($payload, piiFieldMap());

            $score = $instance->do();
    
            if ($score > 0)
            {
                $response = [
                    "message" => "Given data contains some PII.",
                    "score" => $score
                ];
                $data = [
                    "url" => $payload["url"],
                    "url_hash" => getRequestUrlHash($payload, array_unique($instance->getDetectedFields())),
                    "score" => $score
                ];
                Requests::createRequestPii($data);
            }
            else
            {
                $response = [
                    "message" => "No PII was found in the request.",
                    "score" => $score
                ];
            }
            $response = $this->respondWithOkay($response);
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
