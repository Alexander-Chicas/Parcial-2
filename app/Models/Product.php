<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'stock'
    ];

    /**
     * Un producto puede estar en muchas ventas a través de la tabla pivote 'sale_items'.
     * Ahora esperamos la columna 'unit_price' de la tabla pivote.
     */
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_items')
                    ->withPivot('quantity', 'unit_price') // <-- CAMBIO: 'price' a 'unit_price'
                    ->withTimestamps();
    }

    // Relación uno a muchos con el modelo Alert
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}