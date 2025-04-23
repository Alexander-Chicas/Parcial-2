<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alert extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'threshold', 'is_triggered'
    ];

    // Relación con la tabla 'product'
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
