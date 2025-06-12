<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alert; // Importa el modelo Alert

class AlertController extends Controller
{
    public function index()
    {
        // Para empezar, puedes cargar todas las alertas (o solo las no leídas)
        // Esto solo es un ejemplo; podrías querer paginar, filtrar, etc.
        $alerts = Alert::latest()->get(); // Obtiene las alertas más recientes

        return view('alerts.index', compact('alerts')); // Retorna una vista llamada alerts/index.blade.php
    }
}