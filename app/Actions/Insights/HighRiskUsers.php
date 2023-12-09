<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;

class HighRiskUsers implements Actionable
{
    public const TYPE_FREQUENCY = 1;

    public const TYPE_RANDOM = 2;

    public function __construct(protected int $count = 10)
    {
        //
    }

    public function do() : array
    {
        return [
            ["user_id" => 2, "name" => "Aviral", "email" => "aviral@shiprocket.com"],
            ["user_id" => 3, "name" => "Vinod", "email" => "vinod@shiprocket.com"],
            ["user_id" => 4, "name" => "Richa", "email" => "richa@shiprocket.com"],
            ["user_id" => 5, "name" => "Bhupendra", "email" => "bhupendra@shiprocket.com"]
        ];
    }
}
