<?php

namespace App\Http\Resources\Internal\Roles;

use Illuminate\Http\Resources\Json\JsonResource;

class RoleResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "key" => $this->key,
            "name" => $this->name
        ];
    }
}
