<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;

class BreachedPIIScreens implements Actionable
{
    public function do() : array
    {
        return [
            ["url" => "", "tag" => "Shipment Details", "percentage" => 10],
            ["url" => "", "tag" => "Order Details", "percentage" => 20],
            ["url" => "", "tag" => "Awb Details", "percentage" => 15],
            ["url" => "", "tag" => "Customer Details", "percentage" => 22],
        ];
    }
}
