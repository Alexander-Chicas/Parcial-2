<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_id', 'product_id', 'quantity', 'unit_price', 'total_price'
    ];

    // Relación con la tabla 'sale'
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Relación con la tabla 'product'
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
