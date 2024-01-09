<?php

namespace App\Http\Resources\Internal\Alerts;

use App\Http\Resources\Internal\Users\UserResource;
use App\Models\Alert;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "id" => $this->id,
            "user" => $this->whenLoaded("user", fn() => new UserResource($this->user)),
            "type" => self::getType($this->type),
            "viewed" => $this->viewed,
            "actionable" => $this->action_taken != 1,
            "timestamps" => [
                "created" => date(TIMESTAMP_STANDARD, strtotime($this->created_at)),
                "updated" => date(TIMESTAMP_STANDARD, strtotime($this->updated_at)),
            ]
        ];
    }

    public static function getType($type) : string
    {
        return Alert::NAMES[$type] ?? "N/A";
    }
}
