<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id();  // Crea una columna 'id' de tipo autoincremental
            $table->foreignId('product_id')->constrained()->onDelete('cascade');  // Relación con la tabla 'products'
            $table->integer('threshold');  // Umbral de stock bajo
            $table->boolean('is_triggered')->default(false);  // Indica si se ha activado la alerta
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
        Schema::dropIfExists('alerts');  // Elimina la tabla 'alerts'
    }
}
