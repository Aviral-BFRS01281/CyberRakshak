<?php

namespace App\Http\Resources\Internal\Journey;

use Illuminate\Http\Resources\Json\ResourceCollection;

class JourneyCollection extends ResourceCollection
{
    public $collects = JourneyResource::class;
}
