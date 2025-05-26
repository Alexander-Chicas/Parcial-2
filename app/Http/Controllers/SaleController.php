<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log; // ¡Importante: Asegúrate de que esta línea esté presente!


class SaleController extends Controller
{
    public function index()
    {
        $ventas = Sale::with('user', 'products')->orderByDesc('sale_date')->get();
        return view('ventas', compact('ventas'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::all();
        $currentDate = Carbon::now(); // Para precargar la fecha actual
        return view('crear-venta', compact('users', 'products', 'currentDate'));
    }

    public function store(Request $request)
    {
        // --- INICIO BLOQUE DE DEBUGGING ---
        Log::info('Datos de la solicitud (antes de validación - STORE):', $request->all());
        // --- FIN BLOQUE DE DEBUGGING ---

        DB::beginTransaction(); // Inicia una transacción de base de datos

        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'sale_date' => 'required|date',
                'products' => 'required|array|min:1', // Asegurarse de que haya al menos un producto
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.unit_price' => 'required|numeric|min:0', // Asegurarse de que unit_price se reciba y sea numérico
            ], [
                'user_id.required' => 'El usuario es obligatorio.',
                'user_id.exists' => 'El usuario seleccionado no es válido.',
                'sale_date.required' => 'La fecha de venta es obligatoria.',
                'sale_date.date' => 'La fecha de venta no tiene un formato válido.',
                'products.required' => 'Debe añadir al menos un producto a la venta.',
                'products.min' => 'Debe añadir al menos un producto a la venta.',
                'products.*.product_id.required' => 'El ID del producto es obligatorio.',
                'products.*.product_id.exists' => 'El producto seleccionado no existe.',
                'products.*.quantity.required' => 'La cantidad del producto es obligatoria.',
                'products.*.quantity.integer' => 'La cantidad debe ser un número entero.',
                'products.*.quantity.min' => 'La cantidad debe ser al menos 1.',
                'products.*.unit_price.required' => 'El precio unitario del producto es obligatorio.',
                'products.*.unit_price.numeric' => 'El precio unitario debe ser un número.',
                'products.*.unit_price.min' => 'El precio unitario debe ser al menos 0.',
            ]);

            // --- INICIO BLOQUE DE DEBUGGING ---
            Log::info('Datos de la solicitud (después de validación - STORE):', $validatedData);
            // --- FIN BLOQUE DE DEBUGGING ---

            // Crear la venta
            $sale = Sale::create([
                'user_id' => $validatedData['user_id'],
                'sale_date' => $validatedData['sale_date'],
                'total_amount' => 0, // Inicializar el total_amount a 0, se actualizará después
            ]);

            $totalAmount = 0;
            $saleItems = []; // Para almacenar los datos de los ítems de venta para attach

            foreach ($validatedData['products'] as $productData) {
                $product_id = $productData['product_id'];
                $quantity = $productData['quantity'];
                $unit_price = $productData['unit_price']; // Precio unitario enviado desde el formulario

                // Calcular el total_price para este ítem
                $itemTotalPrice = $unit_price * $quantity;

                $saleItems[$product_id] = [
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'total_price' => $itemTotalPrice, // ¡Añadimos total_price aquí! Esto soluciona el error NOT NULL
                    'created_at' => now(), // Asegurarse de que los timestamps se guarden
                    'updated_at' => now(), // Asegurarse de que los timestamps se guarden
                ];
                $totalAmount += $itemTotalPrice;
            }

            // Adjuntar los productos a la venta con sus datos pivot
            // Usamos attach con un array de datos para cada producto para insertar todos los campos pivot
            $sale->products()->attach($saleItems);

            // Actualizar el total_amount de la venta una vez que todos los ítems han sido procesados
            $sale->update(['total_amount' => $totalAmount]);

            DB::commit(); // Confirmar la transacción

            // --- INICIO BLOQUE DE DEBUGGING ---
            Log::info('Total calculado (STORE):', ['total_amount' => $totalAmount]);
            // --- FIN BLOQUE DE DEBUGGING ---

            return redirect()->route('ventas.index')->with('success', 'Venta registrada con éxito.');

        } catch (ValidationException $e) {
            DB::rollBack();
            // Este bloque se ejecuta si la validación falla.
            Log::error('Error de validación al registrar venta (STORE):', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción en caso de error
            // Este bloque captura cualquier otra excepción.
            Log::error('Error inesperado al registrar venta (STORE): ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Hubo un error al registrar la venta. Por favor, inténtelo de nuevo.')->withInput();
        }
    }

    public function show(Sale $venta)
    {
        // Carga la relación 'products' con sus datos pivote ('quantity', 'unit_price', 'total_price')
        $venta->load(['products' => function($query) {
            $query->withPivot('quantity', 'unit_price', 'total_price');
        }, 'user']);
        return view('mostrar-venta', compact('venta'));
    }

    // Método para mostrar el formulario de edición
    public function edit(Sale $venta)
    {
        $users = User::all();
        $products = Product::all(); // Todos los productos para el select
        // Asegúrate de cargar los productos de la venta con sus datos de la tabla pivote
        $venta->load(['products' => function($query) {
            $query->withPivot('quantity', 'unit_price', 'total_price'); // Carga total_price también
        }]);

        // PREPARAR existingSaleItems aquí en el controlador para pasarlos al JS de la vista
        $existingSaleItems = $venta->products->map(function($product) {
            return [
                'product_id' => $product->id,
                'quantity' => $product->pivot->quantity,
                'unit_price' => $product->pivot->unit_price, // Precio unitario de la venta
                // No necesitamos total_price del pivot aquí para el JS de edición, se recalcula en el frontend
                'product_name' => $product->name,
                'product_price' => $product->price // Precio actual del producto (para comparación o fallback)
            ];
        })->toArray(); // Convertir la colección a un array puro

        return view('editar-venta', compact('venta', 'users', 'products', 'existingSaleItems'));
    }

    // Método para manejar la actualización de la venta
    public function update(Request $request, Sale $venta)
    {
        // --- INICIO BLOQUE DE DEBUGGING ---
        Log::info('Datos de la solicitud de actualización (antes de validación - UPDATE):', $request->all());
        // --- FIN BLOQUE DE DEBUGGING ---

        DB::beginTransaction(); // Inicia una transacción

        try {
            $validatedData = $request->validate([
                'user_id' => 'required|exists:users,id',
                'sale_date' => 'required|date',
                'products' => 'required|array|min:1',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
                'products.*.unit_price' => 'required|numeric|min:0', // Validar el precio unitario
            ], [
                'user_id.required' => 'El usuario es obligatorio.',
                'user_id.exists' => 'El usuario seleccionado no es válido.',
                'sale_date.required' => 'La fecha de venta es obligatoria.',
                'sale_date.date' => 'La fecha de venta no tiene un formato válido.',
                'products.required' => 'Debe añadir al menos un producto a la venta.',
                'products.min' => 'Debe añadir al menos un producto a la venta.',
                'products.*.product_id.required' => 'El ID del producto es obligatorio.',
                'products.*.product_id.exists' => 'El producto seleccionado no existe.',
                'products.*.quantity.required' => 'La cantidad del producto es obligatoria.',
                'products.*.quantity.integer' => 'La cantidad debe ser un número entero.',
                'products.*.quantity.min' => 'La cantidad debe ser al menos 1.',
                'products.*.unit_price.required' => 'El precio unitario del producto es obligatorio.',
                'products.*.unit_price.numeric' => 'El precio unitario debe ser un número.',
                'products.*.unit_price.min' => 'El precio unitario debe ser al menos 0.',
            ]);

            // --- INICIO BLOQUE DE DEBUGGING ---
            Log::info('Datos de la solicitud de actualización (después de validación - UPDATE):', $validatedData);
            // --- FIN BLOQUE DE DEBUGGING ---

            // Actualizar la venta principal (total_amount se actualizará después de procesar los ítems)
            $venta->update([
                'user_id' => $validatedData['user_id'],
                'sale_date' => $validatedData['sale_date'],
                // 'total_amount' se actualizará después de procesar los ítems
            ]);

            $totalAmount = 0;
            $syncData = []; // Para almacenar los datos de los ítems de venta para sincronizar

            foreach ($validatedData['products'] as $productData) {
                $product_id = $productData['product_id'];
                $quantity = $productData['quantity'];
                $unit_price = $productData['unit_price'];

                // Calcular el total_price para este ítem
                $itemTotalPrice = $unit_price * $quantity;

                $syncData[$product_id] = [
                    'quantity' => $quantity,
                    'unit_price' => $unit_price,
                    'total_price' => $itemTotalPrice, // ¡Añadimos total_price aquí! Esto soluciona el error NOT NULL
                    'created_at' => now(), // Mantener o actualizar timestamps
                    'updated_at' => now(),
                ];
                $totalAmount += $itemTotalPrice;
            }

            // Sincronizar los productos de la venta (eliminar los que ya no están, añadir los nuevos, actualizar los existentes)
            // 'sync' es útil para actualizar relaciones BelongsToMany
            $venta->products()->sync($syncData);

            // Actualizar el total_amount de la venta una vez que todos los ítems han sido procesados
            $venta->update(['total_amount' => $totalAmount]);

            DB::commit(); // Confirmar la transacción

            // --- INICIO BLOQUE DE DEBUGGING ---
            Log::info('Venta actualizada, Total calculado (UPDATE):', ['total_amount' => $totalAmount]);
            // --- FIN BLOQUE DE DEBUGGING ---

            return redirect()->route('ventas.index')->with('success', 'Venta actualizada con éxito.');

        } catch (ValidationException $e) {
            DB::rollBack();
            Log::error('Error de validación al actualizar venta (UPDATE):', $e->errors());
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack(); // Revertir la transacción
            Log::error('Error inesperado al actualizar venta (UPDATE): ' . $e->getMessage(), ['exception' => $e]);
            return redirect()->back()->with('error', 'Hubo un error al actualizar la venta. Por favor, inténtelo de nuevo.')->withInput();
        }
    }

    public function destroy(Sale $venta)
    {
        try {
            $venta->delete();
            return redirect()->route('ventas.index')->with('success', 'Venta eliminada con éxito.');
        } catch (\Exception $e) {
            return redirect()->route('ventas.index')->with('error', 'No se pudo eliminar la venta.');
        }
    }
}