<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->id();  // Crea una columna 'id' de tipo autoincremental
            $table->foreignId('user_id')->constrained()->onDelete('cascade');  // Relación con el usuario (cliente o vendedor)
            $table->dateTime('sale_date');  // Fecha y hora de la venta
            $table->decimal('total_amount', 8, 2);  // Monto total de la venta
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
        Schema::dropIfExists('sales');  // Elimina la tabla 'sales'
    }
}
