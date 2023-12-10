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
            "user_id" => ["required", "integer", "min:0"],
            "ip" => ["required", "ip"],
            "verb" => ["required", "string", "in:GET,POST,PUT,DELETE,HEAD,OPTIONS"],
            "meta" => ["sometimes", "array"],
            "body" => ["requires", "array"],
            "params" => ["sometimes", "array"]
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
