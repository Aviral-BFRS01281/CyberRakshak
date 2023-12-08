<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PiiLog extends Model
{
    use HasFactory;
    protected $table = 'pii_logs';
    protected $fillable = ['request_id', 'user_id', 'pii_score'];
    public static function createPiiLog($data) {
        $piiLogData = [
            'request_id' => $data['request_id'],
            'user_id' => $data['user_id'],
            'pii_score' => $data['score'],
            'pii_data' => json_encode($data['pii_data']),
        ];
        // Create a new record
        PiiLog::create($piiLogData);
    }
}
