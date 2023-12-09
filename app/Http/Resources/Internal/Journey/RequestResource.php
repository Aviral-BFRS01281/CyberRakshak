<?php

namespace App\Http\Resources\Internal\Journey;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "url" => $this->url,
            "tag" => $this->tag,
        ];
    }
}
