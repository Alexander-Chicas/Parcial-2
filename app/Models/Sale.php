<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'sale_date', 'total_amount'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'sale_items')
                    ->withPivot('quantity', 'price');
    }

    public function saleItems()
    {
        return $this->hasMany(SaleItem::class);
    }

}
