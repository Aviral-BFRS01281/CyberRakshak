<?php

namespace App\Http\Resources\Internal\Alerts;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AlertCollection extends ResourceCollection
{
    public $collects = AlertResource::class;
}
