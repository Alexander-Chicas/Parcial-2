<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;    // Añadido para Usuarios
use App\Http\Controllers\ProductController;  // Añadido para Productos
use App\Http\Controllers\SaleController;     // Añadido para Ventas
use App\Http\Controllers\AlertController;    // Añadido para Alertas

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Rutas de perfil generadas por Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Rutas para la gestión de usuarios
    Route::resource('usuarios', UserController::class);

    // Rutas para la gestión de productos
    Route::resource('productos', ProductController::class);

    // Rutas para la gestión de ventas
    Route::resource('ventas', SaleController::class);

    // Ruta para visualizar alertas
    Route::get('/alertas', [AlertController::class, 'index'])->name('alertas');
});

require __DIR__.'/auth.php';
