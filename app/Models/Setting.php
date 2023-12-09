<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $fillable = ['key', 'value'];
    protected $primaryKey = 'key'; // Set the primary key column
    public $timestamps = false; // Disable automatic timestamp columns
    public $incrementing = false; // Disable auto-incrementing for the primary key

    public static function getSettings() {
        return Setting::all();
    }

    public static function updateOrCreateSetting($key, $value)
    {
        return self::updateOrCreate(['key' => $key], ['value' => $value]);
    }
}
