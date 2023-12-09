<?php

namespace App\Models\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class URLTag extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public $incrementing = false;
}
