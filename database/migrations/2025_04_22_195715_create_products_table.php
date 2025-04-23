<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();  // Crea una columna 'id' de tipo autoincremental
            $table->string('name');  // Nombre del producto
            $table->text('description');  // Descripción del producto
            $table->decimal('price', 8, 2);  // Precio del producto con 2 decimales
            $table->integer('stock');  // Cantidad en inventario
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
        Schema::dropIfExists('products');  // Elimina la tabla 'products'
    }
}


