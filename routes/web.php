<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('inicio');
});

Route::get('/productos', [ProductController::class, 'index']);
Route::get('/ventas', [SaleController::class, 'index']);
Route::get('/usuarios', [UserController::class, 'index']);
Route::get('/productos/crear', [ProductController::class, 'create']);
Route::post('/productos', [ProductController::class, 'store']);
Route::get('/productos/{id}/editar', [ProductController::class, 'edit']);
Route::put('/productos/{id}', [ProductController::class, 'update']);
Route::delete('/productos/{id}', [ProductController::class, 'destroy']);
