<?php

namespace App\Http\Controllers;

use App\Http\Requests\External\LogRequest;
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
            
        }
        catch (ValidationException $exception)
        {

        }
        catch (\Throwable $exception)
        {

        }
    }
}
