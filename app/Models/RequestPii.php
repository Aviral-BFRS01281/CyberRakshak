<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPii extends Model
{
    use HasFactory;
    protected $table = 'request_piis';
    protected $fillable = ['request_id', 'name', 'mobile', 'email', 'awb'];
    public static function createRequestPii($data) {
        $is_request_exist = RequestPii::Where("request_id", $data["request_id"])->first();
        if(empty($is_request_exist)) {
            $requestData = [
                'request_id' => $data['request_id'],
                'name' => !empty($data['name']) ? 1 : 0,
                'mobile' => !empty($data['mobile']) ? 1 : 0,
                'email' => !empty($data['email']) ? 1 : 0,
                'awb' => !empty($data['awb']) ? 1 : 0,
            ];
            RequestPii::create($requestData);
        }
    }
}
