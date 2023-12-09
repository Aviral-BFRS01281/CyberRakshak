<?php

namespace App\Models;

use App\Library\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PiiAccess extends Model
{
    use HasFactory;

    protected $table = 'pii_access';

    public function siblings() : Builder
    {
        return static::query()->where("user_id", $this->user_id)->where("request_id", $this->request_id);
    }

    public function request() : BelongsTo
    {
        return $this->belongsTo(Request::class);
    }
}
