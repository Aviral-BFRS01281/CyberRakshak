<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiiField extends Model
{
    use HasFactory;

    protected $table = "pii_fields";
}
