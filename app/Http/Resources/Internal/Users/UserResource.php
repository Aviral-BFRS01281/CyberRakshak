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
            "last_active" => $this->last_active,
            "mobile" => $this->mobile,
            "timestamps" => [
                "created" => $this->whenPivotLoaded("awb_access", fn() => date(TIMESTAMP_STANDARD, strtotime($this->pivot->created_at))),
                "updated" => $this->whenPivotLoaded("awb_access", fn() => date(TIMESTAMP_STANDARD, strtotime($this->pivot->updated_at))),
            ]
        ];
    }
}
