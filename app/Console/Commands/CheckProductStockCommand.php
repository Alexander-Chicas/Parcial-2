<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Product; // Asegúrate de importar el modelo Product
use App\Models\Alert;   // Asegúrate de importar el modelo Alert

class CheckProductStockCommand extends Command
{
    protected $signature = 'alerts:check-stock'; // Así se llamará el comando
    protected $description = 'Checks product stock levels and generates low stock alerts.';

    public function handle()
    {
        $products = Product::all(); // Obtiene todos tus productos

        foreach ($products as $product) {
            // Lógica para determinar si el stock está bajo
            if ($product->stock <= $product->min_stock_threshold && $product->stock >= 0) { // Incluye 0 stock
                // Buscar si ya existe una alerta activa para este producto
                $alert = Alert::where('product_id', $product->id)
                              ->where('is_triggered', true) // Solo buscar alertas que ya están activas
                              ->first();

                if (!$alert) {
                    // Si NO existe una alerta activa, creamos una nueva
                    Alert::create([
                        'product_id' => $product->id,
                        'threshold' => $product->min_stock_threshold,
                        'message' => "¡Inventario bajo! El producto '{$product->name}' tiene solo {$product->stock} unidades restantes.",
                        'type' => 'danger',
                        'icon' => 'fas fa-boxes', // Icono de cajas
                        'is_triggered' => true,
                        'is_read' => false, // Nueva alerta, no está leída
                    ]);
                    $this->info("Alerta GENERADA para el producto: {$product->name}");
                } else {
                    // Si YA existe una alerta activa, la actualizamos (ej. si el stock ha cambiado pero sigue bajo)
                    $alert->update([
                        'message' => "¡Inventario bajo! El producto '{$product->name}' tiene solo {$product->stock} unidades restantes.",
                        // No cambiamos is_read aquí, ya que el usuario podría haberla descartado
                    ]);
                    $this->info("Alerta ACTUALIZADA para el producto: {$product->name}");
                }
            } else {
                // Si el stock ya NO está bajo (subió por encima del umbral)
                // Desactivar cualquier alerta activa para este producto
                Alert::where('product_id', $product->id)
                     ->where('is_triggered', true)
                     ->update([
                         'is_triggered' => false,
                         'is_read' => true, // La marcamos como leída/resuelta cuando se desactiva
                     ]);
                $this->info("Alerta DESACTIVADA para el producto: {$product->name}");
            }
        }

        $this->info('Comprobación de stock finalizada.');
    }
}