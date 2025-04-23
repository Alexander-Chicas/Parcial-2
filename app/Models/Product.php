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

    
    public function sales()
    {
        return $this->belongsToMany(Sale::class, 'sale_items')
                    ->withPivot('quantity', 'price');
    }
    // Relación con la tabla 'alerts'
    public function alerts()
    {
        return $this->hasMany(Alert::class);
    }
}
