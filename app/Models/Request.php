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
class Request extends Model
{
    use HasFactory;

    protected $table = 'request_piis';

    protected $guarded = ["id"];

    protected $primaryKey = "request_id";

    public $incrementing = false;

    public static function createRequestPii($data) : void
    {
        $is_request_exist = Request::where("request_id", $data["request_id"])->first();
        if (empty($is_request_exist))
        {
            $requestData = [
                'request_id' => $data['request_id'],
                'name' => !empty($data['name']) ? 1 : 0,
                'mobile' => !empty($data['mobile']) ? 1 : 0,
                'email' => !empty($data['email']) ? 1 : 0,
                'awb' => !empty($data['awb']) ? 1 : 0,
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
        return Request::query()->find($url);
    }

    public function logs() : HasMany
    {
        return $this->hasMany(PiiLog::class, "request_id", "request_id");
    }
}
