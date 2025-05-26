<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    // Define los campos que se pueden asignar masivamente
    protected $fillable = [
        'user_id',
        'sale_date',    // <-- AÑADIDO: Para coincidir con la migración
        'total_amount', // <-- CAMBIO: De 'total' a 'total_amount'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sale_date' => 'datetime', // Castear sale_date a Carbon instance
    ];

    /**
     * Define la relación con el modelo User (si las ventas están asociadas a usuarios).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define la relación muchos a muchos con el modelo Product a través de la tabla pivote 'sale_items'.
     * 'withPivot' especifica las columnas adicionales en la tabla 'sale_items'.
     * Ahora incluimos 'unit_price' para que coincida con el nombre de la columna en tu migración (asumiendo que es la correcta).
     */
    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_items')
                    ->withPivot('quantity', 'unit_price') // Manteniendo 'unit_price' por nuestras conversaciones previas
                    ->withTimestamps();
    }
}