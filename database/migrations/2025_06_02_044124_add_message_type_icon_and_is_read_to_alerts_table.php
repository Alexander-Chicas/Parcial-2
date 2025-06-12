<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('alerts', function (Blueprint $table) {
            // Eliminar la columna 'threshold' si existe, ya que el nuevo diseño usa 'min_stock_threshold' en productos.
            // La imagen muestra que 'threshold' existe, así que la eliminamos.
            if (Schema::hasColumn('alerts', 'threshold')) {
                $table->dropColumn('threshold');
            }

            // Añadir las nuevas columnas necesarias para la gestión de alertas
            // Estas columnas son las que faltan y causan el error "no such column: is_read".
            $table->string('message')->nullable()->after('product_id'); // Mensaje descriptivo de la alerta
            $table->string('type')->default('info')->after('message');   // Tipo de alerta (ej. 'danger', 'warning', 'info')
            $table->string('icon')->nullable()->after('type');           // Clase de icono (ej. 'fas fa-exclamation-triangle')
            $table->boolean('is_read')->default(false)->after('is_triggered'); // Estado para saber si la alerta ha sido vista/leída
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alerts', function (Blueprint $table) {
            // Revertimos los cambios en el orden inverso al que se añadieron
            $table->dropColumn('is_read');
            $table->dropColumn('icon');
            $table->dropColumn('type');
            $table->dropColumn('message');

            // Opcional: Si necesitas restaurar 'threshold' en el rollback, puedes hacerlo aquí.
            // Para el flujo de trabajo actual, no es estrictamente necesario, ya que la lógica
            // se trasladó a 'min_stock_threshold' en la tabla de productos.
            // $table->integer('threshold')->nullable();
        });
    }
};