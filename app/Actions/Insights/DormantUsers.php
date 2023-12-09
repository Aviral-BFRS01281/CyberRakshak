<?php

namespace App\Actions\Insights;

use App\Actions\Actionable;

class DormantUsers implements Actionable
{
    public function do() : array
    {
        return [
            ["name" => "Admins", "count" => 22],
            ["name" => "Others", "count" => 55],
        ];
    }
}
