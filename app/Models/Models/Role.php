<?php

namespace App\Models\Models;

use App\Library\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    public $timestamps = false;

    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class, "user_roles", "user_id", "role_id");
    }
}
