<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OperationalLog extends Model
{
    use HasFactory;

    protected $table = 'operational_logs';

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'action',
        'status',
        'error_message',
        'latency_ms',
    
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}