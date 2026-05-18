<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

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

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}