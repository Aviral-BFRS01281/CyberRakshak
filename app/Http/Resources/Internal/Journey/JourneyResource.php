<?php

namespace App\Http\Resources\Internal\Journey;

use Illuminate\Http\Resources\Json\JsonResource;

class JourneyResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "score" => $this->score,
            "meta" => $this->meta,
            "request" => $this->whenLoaded("request", fn() => new RequestResource($this->request)),
            "timestamps" => [
                "created" => $this->created_at,
                "updated" => $this->updated_at,
            ]
        ];
    }
}
