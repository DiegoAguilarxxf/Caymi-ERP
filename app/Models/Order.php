<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    public $incrementing = true;
    protected $keyType = 'string';
    protected $fillable = [
        'user_id',
        'product_id',
        'customization',
        'quantity',
        'status',
        'admin_id',
        'similarity_score',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Cliente que realizó el pedido
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Producto solicitado
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Administrador que gestiona el pedido
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Un pedido puede generar varios embeddings
    public function embeddings()
    {
        return $this->hasMany(Embedding::class);
    }
}