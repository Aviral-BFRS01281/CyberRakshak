<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    const TYPE_PII = 0;

    const TYPE_AWB = 1;

    use HasFactory;

    protected $guarded = ["id"];
}
