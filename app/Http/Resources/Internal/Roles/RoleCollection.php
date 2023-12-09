<?php

namespace App\Http\Resources\Internal\Roles;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;

class RoleCollection extends ResourceCollection
{
    public $collects = JsonResponse::class;
}
