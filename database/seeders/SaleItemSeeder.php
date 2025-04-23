<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SaleItem;


class SaleItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Insertar datos de prueba en la tabla sale_items
        SaleItem::create([
            'sale_id' => 1,
            'product_id' => 1,
            'quantity' => 2,
            'unit_price' => 1.25,  // Precio unitario del producto
            'total_price' => 2.50,  // Precio total (quantity * unit_price)
        ]);

        SaleItem::create([
            'sale_id' => 1,
            'product_id' => 2,
            'quantity' => 3,
            'unit_price' => 2.50,
            'total_price' => 7.50,
        ]);
    }
}
