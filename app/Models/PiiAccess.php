<?php

namespace App\Models;

use App\Library\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PiiAccess extends Model
{
    use HasFactory;

    protected $table = 'pii_access';
}
