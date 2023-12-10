<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property integer $id
 * @property string $url
 * @property string $url_hash
 * @property integer $score
 */
class Request extends \App\Library\Model
{
    use HasFactory;

    protected $guarded = ["id"];

    protected $casts = [
        "created_at" => "string",
        "updated_at" => "string",
        "meta" => "array",
    ];

    public static function createRequestPii($data) : void
    {
        $is_request_exist = Request::where("url_hash", $data["url_hash"])->first();
        if (empty($is_request_exist))
        {
            $requestData = [
                'url' => $data['url'],
                'url_hash' => $data['url_hash'],
                'score' => $data['score']
            ];
            Request::create($requestData);
        }
    }

    /**
     * Get the request instance for the given URL.
     *
     * @param string $url
     * @return Request|Model|null
     */
    public static function findWithURL(string $url) : Request|Model|null
    {
        return Request::query()->where("url", $url)->first();
    }

    /**
     * Get the request instance for the given URL.
     *
     * @param string $hash
     * @return Request|Model|null
     */
    public static function findWithHash(string $hash) : Request|Model|null
    {
        return Request::query()->where("url_hash", $hash)->first();
    }

    public function logs() : HasMany
    {
        return $this->hasMany(PiiAccess::class, "id", "request_id");
    }
}
