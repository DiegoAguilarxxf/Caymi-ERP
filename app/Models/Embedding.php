<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Embedding extends Model
{
    use HasFactory;

    protected $table = 'embeddings';

    public $timestamps = true;

    const CREATED_AT = 'created_at';
    const UPDATED_AT = null;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'product_id',
        'order_id',
        'vector_reference',
        'embedding_model',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Producto al que pertenece el embedding
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Pedido relacionado (opcional)
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}