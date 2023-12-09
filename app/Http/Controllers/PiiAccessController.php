<?php

namespace App\Http\Controllers;

use App\Http\Resources\Internal\Users\UserCollection;
use App\Models\Models\Awb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class PiiAccessController extends APIController
{
    public function show(string $awb)
    {
        try
        {
            # Disabling outer wrapping as this is flat set.
            UserCollection::withoutWrapping();

            $awb = Awb::findByAwb($awb, ["users"])->first();

            return (new UserCollection($awb->users));
        }
        catch (Throwable $exception)
        {
            Log::error("PiiAccessControllerShowException", [
                "message" => $exception->getMessage(),
                "trace" => $exception->getTrace()
            ]);

            $response = $this->respondWithServerError([
                "message" => "We ran into an error while processing your request."
            ]);
        }

        return $response;
    }

    public function download(Request $request) : JsonResponse
    {
        try
        {
            $this->validate($request, [
                "awb" => ["required", "array"],
                "awb.*" => ["string"]
            ]);

            $response = $this->respondWithOkay();
        }
        catch (ValidationException $exception)
        {
            $response = $this->respondWithBadRequest();
        }
        catch (Throwable $exception)
        {
            $response = $this->respondWithServerError();
        }

        return $response;
    }
}
