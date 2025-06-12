<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'threshold',
        'message',       // ¡Importante!
        'type',          // ¡Importante!
        'icon',          // ¡Importante!
        'is_read',       // ¡Importante!
        'is_triggered',
    ];

    // Relación con la tabla 'products' (una alerta pertenece a un producto)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}