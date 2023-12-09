<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use League\Csv\CannotInsertRecord;
use League\Csv\Writer;

class DownloadAwbReportController extends APIController
{
    /**
     * Generates and initiates download of PII incidents report sheet.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws CannotInsertRecord
     * @throws ValidationException
     */
    public function download(Request $request) : JsonResponse
    {
        $this->validate($request, [
            "awb" => ["required", "string", "min:2"]
        ]);

        $response = getSrAwbData($request->awb);

        if ($response->successful())
        {
            $data = $response->json();

            $csv = Writer::createFromFileObject(new \SplTempFileObject());

            $csv->insertOne(['AWB', 'Company Name', 'Order Created At', 'Courier', 'Delivery Date', 'Channel Name', 'Engage', 'Checkout', 'Pii User', 'Order Export', 'NDR Flow']);

            header('Content-Type: text/csv');

            $filename = 'PiiData_' . time() . '.csv';

            header('Content-Disposition: attachment; filename="' . $filename . '"');

            if (!empty($data) && !empty($data['data']))
            {
                foreach ($data['data'] as $csv_data)
                {

                    $csv->insertOne([$csv_data['awb'], $csv_data['company_name'], $csv_data['order_creation_date'], $csv_data['courier'], $csv_data['delivered_date'], $csv_data['channel_name'], !empty($csv_data['is_engage_enabled']) ? 'Yes' : "No", !empty($csv_data['is_checkout_enable']) ? 'Yes' : "No", !empty($csv_data['pii_user']) ? 'Yes' : "No", !empty($csv_data['order_export']) ? 'Yes' : "No", !empty($csv_data['ndr_id']) ? 'Yes' : "No"]);
                }

                $csv->output();
            }
            else
            {
                return $this->respondWithBadRequest([
                    "message" => "No data found"
                ]);
            }
        }
        else
        {
            return $this->respondWithServerError([
                "message" => "We ran into an error. Please try again in a while."
            ]);
        }
    }
}
