<?php

namespace App\Http\Controllers;

use App\Models\Sale;

class SaleController extends Controller
{
     public function index()
    {
        $ventas = Sale::all();
        return view('ventas', ['ventas' => $ventas]);
    }
}
