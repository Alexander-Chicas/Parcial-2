<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Coca Cola',
            'description' => 'Bebida gaseosa de 500ml',
            'stock' => 50,
            'price' => 1.25,
        ]);

        Product::create([
            'name' => 'Pan',
            'description' => 'Pan francés recién horneado',
            'stock' => 100,
            'price' => 0.15,
        ]);
}
}
