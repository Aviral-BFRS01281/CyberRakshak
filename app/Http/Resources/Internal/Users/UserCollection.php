<?php

namespace App\Http\Resources\Internal\Users;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    public $collects = UserResource::class;

    public static $wrap = null;
}
