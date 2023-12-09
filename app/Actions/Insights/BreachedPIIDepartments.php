<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;

class BreachedPIIDepartments implements Actionable
{
    public function __construct(protected int $count = 10)
    {
        //
    }

    public function do() : array
    {
        return [
            ["name" => "Admin", "value" => 220],
            ["name" => "KAM", "value" => 110],
            ["name" => "Customer Support", "value" => 22],
            ["name" => "LOPS", "value" => 10],
        ];
    }
}
