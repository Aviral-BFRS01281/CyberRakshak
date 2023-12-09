<?php

namespace App\Models;

use App\Library\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Awb extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, AwbAccess::class, "awb_id", "user_id")->withPivot(["created_at", "updated_at"]);
    }

    public static function findByAwb(string $awb, array $with = []) : Builder
    {
        return static::query()->with($with)->where("awb", $awb);
    }

    public static function latest(int $daysInPast = 1, array $with = []) : Builder
    {
        return static::query()->with($with)->where("created_at", ">", now()->subDays($daysInPast)->startOfDay()->format(TIMESTAMP_STANDARD));
    }
}
