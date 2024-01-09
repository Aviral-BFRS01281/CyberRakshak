<?php

namespace App\Http\Requests\External;

use Illuminate\Foundation\Http\FormRequest;

class CheckRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() : array
    {
        return [
            "url" => ["required", "string", "min:4"],
            "user_id" => ["required", "integer", "min:0"],
            "ip" => ["required", "ip"],
            "verb" => ["required", "string", "in:GET,POST,PUT,DELETE,HEAD,OPTIONS"],
            "meta" => ["sometimes", "array"],
            "body" => ["required", "array"],
            "query" => ["sometimes", "array"]
        ];
    }
}
