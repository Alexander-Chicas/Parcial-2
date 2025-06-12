<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Añade el campo 'min_stock_threshold' después de 'stock'
            $table->integer('min_stock_threshold')->default(10)->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Para revertir, se elimina el campo
            $table->dropColumn('min_stock_threshold');
        });
    }
};