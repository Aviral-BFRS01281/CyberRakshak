<?php

namespace App\Http\Resources\Internal\Awbs;

use App\Http\Resources\Internal\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AwbResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "id" => $this->awb,
            "user" => $this->whenLoaded("user", fn() => new UserResource($this->user)),
            "timestamps" => [
                "created" => $this->created_at,
                "updated" => $this->updated_at,
            ]
        ];
    }
}
