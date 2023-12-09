<?php

namespace App\Http\Resources\Internal\Users\Analytics;

use Illuminate\Http\Resources\Json\JsonResource;

class URLResource extends JsonResource
{
    public function toArray($request) : array
    {
        return [
            "url" => $this->url,
            "score" => $this->score,
            "tag" => $this->tag
        ];
    }
}
