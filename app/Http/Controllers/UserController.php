<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios
        $usuarios = User::all();

        // Enviar los usuarios a la vista 'usuarios'
        return view('usuarios', ['usuarios' => $usuarios]);
    }
}
