<?php

namespace App\Http\Resources\Internal\Awbs;

use App\Http\Resources\Internal\Users\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AwbResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "id" => $this->id,
            "awb" => $this->awb,
            "user" => $this->whenLoaded("user", fn() => new UserResource($this->user)),
            "count" => $this->when(isset($this->awb_count), $this->awb_count),
            "timestamps" => [
                "created" => $this->created_at,
                "updated" => $this->updated_at,
            ]
        ];
    }
}
