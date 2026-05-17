<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SemanticSearchLog extends Model
{
    use HasFactory;

    protected $table = 'semantic_search_logs';

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'user_id',
        'query_text',
        'results_count',
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