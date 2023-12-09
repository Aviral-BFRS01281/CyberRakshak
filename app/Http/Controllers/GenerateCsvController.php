<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use League\Csv\Writer;
class GenerateCsvController extends APIController
{
    public function downloadAwbReport(Request $request) {
        if(empty($request->awb)) {
            return $this->respondWithBadRequest(["message" => "AWB is required"]);
        }
        $response = getSrAwbData($request->awb);
        // Check if the request was successful (status code 2xx)
        if ($response->successful()) {
            // Access the response body as an array or JSON
            $data = $response->json();
            // Create a CSV writer
            $csv = Writer::createFromFileObject(new \SplTempFileObject());
            // Add a header row
            $csv->insertOne(['AWB', 'Company Name', 'Order Created At', 'Courier', 'Delivery Date', 'Channel Name', 'Engage', 'Checkout', 'Pii User', 'Order Export', 'NDR Flow']);
            header('Content-Type: text/csv');
            $filename = 'PiiData_'.time().'.csv';
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            if(!empty($data) && !empty($data['data'])) {
                foreach($data['data'] as $csv_data) {
                    // Add data rows
                    $csv->insertOne([$csv_data['awb'], $csv_data['company_name'], $csv_data['order_creation_date'], $csv_data['courier'], $csv_data['delivered_date'], $csv_data['channel_name'], !empty($csv_data['is_engage_enabled']) ? 'Yes' : "No", !empty($csv_data['is_checkout_enable']) ? 'Yes' : "No",!empty($csv_data['pii_user']) ? 'Yes' : "No", !empty($csv_data['order_export']) ? 'Yes' : "No", !empty($csv_data['ndr_id']) ? 'Yes' : "No"]);
                }
                // Output the CSV content to the browser
                $csv->output();
            } else {
                $response = [
                    "message" => "No data found"
                ];  
                return $this->respondWithBadRequest($response);
            }
        } else {
            // Handle the case where the request was not successful
            return $this->respondWithServerError([
                "message" => "We ran into an error. Please try again in a while."
            ]);
        }
    }
}