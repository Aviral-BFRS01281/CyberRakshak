<?php

namespace App\Http\Requests\External;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $url
 * @property integer $user_id
 * @property string $ip
 * @property array $meta
 * @property string $awb
 */
class AwbLogRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules() : array
    {
        return [
            "awb" => ["required", "string"],
            "user_id" => ["required", "integer", "min:0"],
            "meta" => ["sometimes", "array"],
            "ip" => ["sometimes", "string"]
        ];
    }
}
