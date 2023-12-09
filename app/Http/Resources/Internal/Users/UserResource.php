<?php

namespace App\Http\Resources\Internal\Users;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "last_active" => $this->last_active
        ];
    }
}
