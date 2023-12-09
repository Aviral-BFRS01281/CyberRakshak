<?php

namespace App\Http\Resources\Internal\Users\Analytics;

use Illuminate\Http\Resources\Json\ResourceCollection;

class URLCollection extends ResourceCollection
{
    public $collects = URLResource::class;
}
