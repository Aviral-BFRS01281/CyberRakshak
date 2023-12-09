<?php

namespace App\Http\Resources\Internal\Awbs;

use Illuminate\Http\Resources\Json\JsonResource;

class AwbDetailResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "code" => $this->awb,
            "created" => now()->format(TIMESTAMP_STANDARD),
            "company_id" => 2,
            "company_name" => "Shiprocket",
            "courier" => "Delhivery",
            "channel" => "Shopify",
            "status" => "In Transit",
            "shipment_value" => 5400,
            "payment_mode" => "COD",
        ];
    }
}
