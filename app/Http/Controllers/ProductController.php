<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Muestra todos los productos
    public function index()
    {
        $productos = Product::all();  // Trae todos los productos
        return view('productos', ['productos' => $productos]);  // Muestra la vista productos.blade.php
    }

    // Muestra el formulario para crear un producto
    public function create()
    {
        return view('crear');  // Muestra la vista para crear producto
    }

    // Guarda un nuevo producto
    public function store(Request $request)
    {
        // Validación explícita para los campos requeridos
        $request->validate([
            'name' => 'required|string|max:255',   // Nombre del producto
            'price' => 'required|numeric|min:0',    // Precio, debe ser un número mayor o igual a 0
            'stock' => 'required|integer|min:0',    // Stock, debe ser un número entero mayor o igual a 0
            'description' => 'nullable|string',     // Descripción (opcional)
        ]);

        // Crear el producto usando los campos proporcionados
        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,  // Incluye la descripción
        ]);

        // Redirige con un mensaje de éxito
        return redirect('/productos')->with('success', 'Producto creado exitosamente.');
    }

    // Muestra el formulario para editar un producto
    public function edit($id)
    {
        // Obtiene el producto con el id pasado como parámetro
        $producto = Product::findOrFail($id);
        return view('editar', compact('producto'));  // Muestra la vista para editar producto
    }

    // Actualiza los datos de un producto
    public function update(Request $request, $id)
    {
        // Obtiene el producto por su id
        $producto = Product::findOrFail($id);

        // Validación de los campos
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',  // Descripción es opcional
        ]);

        // Actualiza los campos del producto
        $producto->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,  // Incluye la descripción en la actualización
        ]);

        // Redirige con mensaje de éxito
        return redirect('/productos')->with('success', 'Producto actualizado correctamente.');
    }

    // Elimina un producto
    public function destroy($id)
    {
        // Elimina el producto por id
        Product::destroy($id);

        // Redirige con mensaje de éxito
        return redirect('/productos')->with('success', 'Producto eliminado.');
    }
}
