<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Alert;
use Illuminate\Database\Seeder;

class AlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Insertar datos de prueba en la tabla 'alerts'
        Alert::create([
            'product_id' => 1,  // Producto con ID 1
            'threshold' => 10,  // Umbral de stock bajo para este producto
            'is_triggered' => false,  // La alerta no está activada por defecto
        ]);

        Alert::create([
            'product_id' => 2,  // Producto con ID 2
            'threshold' => 5,  // Umbral de stock bajo para este producto
            'is_triggered' => false,  // La alerta no está activada por defecto
        ]);
    }
}
