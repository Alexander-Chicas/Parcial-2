<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();  // Crea una columna 'id' de tipo autoincremental
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');  // Relación con la tabla 'sales'
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Relación con la tabla 'products'
            $table->integer('quantity');  // Cantidad de productos vendidos
            $table->decimal('unit_price', 8, 2);  // Precio unitario del producto
            $table->decimal('total_price', 8, 2);  // Precio total (cantidad * precio unitario)
            $table->timestamps();  // Timestamps (created_at y updated_at)
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sale_items');  // Elimina la tabla 'sale_items'
    }
}
