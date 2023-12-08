<?php

namespace App\Http\Requests\External;

use Illuminate\Foundation\Http\FormRequest;

class LogRequest extends FormRequest
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
            "userId" => ["required", "integer", "min:0"],
            "ip" => ["required", "ip"],
            "meta" => ["sometimes", "array"]
        ];
    }
}
