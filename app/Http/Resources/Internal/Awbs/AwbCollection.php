<?php

namespace App\Http\Resources\Internal\Awbs;

use Illuminate\Http\Resources\Json\ResourceCollection;

class AwbCollection extends ResourceCollection
{
    public $collects = AwbResource::class;
}
