<?php

namespace App\Http\Controllers;

use App\Http\Resources\Internal\Awbs\AwbCollection;
use App\Http\Resources\Internal\Awbs\AwbDetailResource;
use App\Http\Resources\Internal\Users\UserCollection;
use App\Http\Resources\NullResource;
use App\Models\Awb;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class PiiAccessController extends APIController
{
    /**
     * List all PII flagged APIs.
     *
     * @param Request $request
     * @return AwbCollection
     */
    public function index(Request $request) : AwbCollection
    {
        $awbs = Awb::latest();

        if (!empty($request->awb))
        {
            $awbs->where("awb", $request->awb);
        }

        $awbs = $awbs->get();

        return new AwbCollection($awbs);
    }

    /**
     * Show details for the given Awb.
     *
     * @param string $awb
     * @return AwbDetailResource|JsonResponse|NullResource
     */
    public function show(string $awb) : AwbDetailResource|JsonResponse|NullResource
    {
        try
        {
            $awb = Awb::findByAwb($awb, ["users"])->first();

            if ($awb == null)
            {
                AwbDetailResource::wrap(null);

                $response = new NullResource("awb entry");
            }
            else
            {
                AwbDetailResource::wrap("awb");
                $awb_awb_details_data = [];
                $awb_data = getSrAwbData($awb->awb);
                if ($awb_data->successful() && !empty($awb_data->json()['data']))
                {
                    $awb_details = $awb_data->json()['data'][0];
                    $awb_awb_details_data = [
                        "code" => $awb_details["awb"],
                        "company_id" => $awb_details["company_id"],
                        "company_name" => $awb_details["company_name"],
                        "courier" => $awb_details["courier"],
                        "channel" => $awb_details["channel_name"],
                        "status" => $awb_details["status"],
                        "shipment_value" => $awb_details["shipment_value"],
                        "payment_mode" => $awb_details["payment_method"],
                    ];
                }
                $users = (new UserCollection($awb->users));
                $response = (new AwbDetailResource($awb))->additional([
                    "history" => $users, "awb" => $awb_awb_details_data
                ]);
            }
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

    /**
     * Download a report for the given Awb.
     *
     * @param Request $request
     * @return JsonResponse
     */
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
