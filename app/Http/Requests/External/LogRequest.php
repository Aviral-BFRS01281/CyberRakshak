<?php

namespace App\Http\Requests\External;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property string $url
 * @property integer $userId
 * @property string $ip
 * @property array $meta
 */
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
            "verb" => ["required", "string", "in:GET,POST,PUT,HEAD,OPTIONS,DELETE"],
            "user_id" => ["required", "integer", "min:0"],
            "params" => ["sometimes", "array"],
            "ip" => ["sometimes", "string", "min:8", "max:15"],
            "meta" => ["sometimes", "array"]
        ];
    }

    public function getGenerateURL() : ?string
    {
        return vsprintf("%s|%s|%s", [$this->url, $this->verb, implode("|", $this->params)]);
    }

    public function getHashedURL() : ?string
    {
        return sha1($this->getGenerateURL());
    }

    public function getMeta() : array
    {
        return $this->meta ?? [];
    }
}
