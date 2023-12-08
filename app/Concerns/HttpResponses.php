<?php

namespace App\Concerns;

use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

trait HttpResponses
{
    static bool $sendHttpStatusCodeInPayload = false;

    static function sendHttpStatusCodeInPayload(bool $send) : void
    {
        self::$sendHttpStatusCodeInPayload = $send;
    }

    protected function respondWithUnprocessableEntity($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_UNPROCESSABLE_ENTITY;
        }

        return \response()->json($payload, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function respondWithConflict($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_CONFLICT;
        }

        return \response()->json($payload, Response::HTTP_CONFLICT);
    }

    protected function respondWithCreated($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_CREATED;
        }

        return \response()->json($payload, Response::HTTP_CREATED);
    }

    protected function respondWithOkay($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_OK;
        }

        return \response()->json($payload, Response::HTTP_OK);
    }

    protected function respondWithNoContent($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_NO_CONTENT;
        }

        return \response()->json($payload, Response::HTTP_NO_CONTENT);
    }

    protected function respondWithServerError($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        return \response()->json($payload, Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    protected function respondWithBadRequest($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_BAD_REQUEST;
        }

        return \response()->json($payload, Response::HTTP_BAD_REQUEST);
    }

    /**
     * Create a response to signal a 404 not found result.
     *
     * @param mixed $payload The data that is to be sent in response
     * @return JsonResponse
     */
    protected function respondWithNotFound($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_NOT_FOUND;
        }

        return \response()->json($payload, Response::HTTP_NOT_FOUND);
    }

    /**
     * Create a response to signal a 400 Bad request citing additional reasons, if any in the payload.
     *
     * @param $payload
     * @return JsonResponse
     */
    protected function respondWithValidationError($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_BAD_REQUEST;
        }

        return $this->respondWithBadRequest($payload);
    }

    /**
     * Create a response to signal a 401 Unauthenticated citing additional reasons, if any in the payload.
     *
     * @param $payload
     * @return JsonResponse
     */
    protected function respondWithUnauthenticated($payload = null) : JsonResponse
    {
        if (self::$sendHttpStatusCodeInPayload)
        {
            $payload["code"] = Response::HTTP_BAD_REQUEST;
        }

        return \response()->json($payload, Response::HTTP_UNAUTHORIZED);
    }
}
