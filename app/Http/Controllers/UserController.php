<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Asegúrate de que esta línea esté presente si usas el modelo User
use Illuminate\Support\Facades\Auth; // Añadido para la lógica de roles
use Illuminate\Validation\Rule; // Añadido para la validación de roles

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Todos los usuarios pueden ver la lista de usuarios
        $usuarios = User::all();
        return view('usuarios', compact('usuarios'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Solo los administradores pueden acceder al formulario de creación de usuarios
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado. Solo administradores pueden crear usuarios.');
        }
        return view('crear-usuario'); // O la vista que uses para crear usuarios
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Solo los administradores pueden almacenar nuevos usuarios
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado. Solo administradores pueden crear usuarios.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'employee'])],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Todos los usuarios pueden ver el detalle de un usuario (ajusta si es necesario)
        $usuario = User::findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Solo los administradores pueden acceder al formulario de edición de usuarios
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado. Solo administradores pueden editar usuarios.');
        }
        $usuario = User::findOrFail($id);
        return view('editar-usuario', compact('usuario'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Solo los administradores pueden actualizar usuarios
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado. Solo administradores pueden actualizar usuarios.');
        }

        $usuario = User::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($usuario->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['admin', 'employee'])],
        ]);

        $usuario->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? bcrypt($request->password) : $usuario->password,
        ]);

        return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Solo los administradores pueden eliminar usuarios
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Acceso no autorizado. Solo administradores pueden eliminar usuarios.');
        }
        $usuario = User::findOrFail($id);
        $usuario->delete();

        return redirect()->route('usuarios.index')->with('success', 'Usuario eliminado exitosamente.');
    }
}