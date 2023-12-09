<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function awbs() : BelongsToMany
    {
        return $this->belongsToMany(Awb::class, User::class)->withPivot(["created_at", "updated_at"]);
    }

    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, "user_roles", "role_id", "user_id");
    }

    public function hotURLs() : HasManyThrough
    {
        return $this->hasManyThrough(Request::class, PiiAccess::class, "request_id", "id");
    }
}
