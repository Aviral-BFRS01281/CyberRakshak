<?php

namespace App\Library;

class Model extends \Illuminate\Database\Eloquent\Model
{
    protected $guarded = ["id"];

    protected $casts = [
        "created_at" => "string",
        "updated_at" => "string",
    ];
}
