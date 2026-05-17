<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'description',
        'category',
        'colors',
        'price',
        'stock',
        'image_url',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELACIONES
    |--------------------------------------------------------------------------
    */

    // Un producto puede estar en muchos pedidos
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // Un producto puede tener muchos embeddings
    public function embeddings()
    {
        return $this->hasMany(Embedding::class);
    }
}