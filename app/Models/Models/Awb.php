<?php

namespace App\Models\Models;

use App\Library\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Awb extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, AwbAccess::class, "awb_id", "user_id");
    }

    public static function findByAwb(string $awb, array $with = []) : Builder
    {
        return static::query()->with($with)->where("awb", $awb);
    }
}
