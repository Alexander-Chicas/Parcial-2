<x-app-layout>
    {{-- Slot para el encabezado de la página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles de la Venta') }}
        </h2>
    </x-slot>

    {{-- Contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Título de la sección --}}
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">
                    {{ __('Información de la Venta #') }}{{ $venta->id }}
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700 dark:text-gray-300">
                    <div>
                        <p class="mb-2"><strong class="font-semibold">ID de Venta:</strong> {{ $venta->id }}</p>
                        <p class="mb-2"><strong class="font-semibold">ID de Usuario:</strong> {{ $venta->user_id }}</p>
                        {{-- Si tuvieras una relación con el modelo User y quisieras mostrar el nombre: --}}
                        <p class="mb-2"><strong class="font-semibold">Usuario:</strong> {{ $venta->user->name ?? 'N/A' }}</p>
                        <p class="mb-2"><strong class="font-semibold">Total:</strong> ${{ number_format($venta->total_amount, 2) }}</p> {{-- CAMBIO: total a total_amount --}}
                        <p class="mb-2"><strong class="font-semibold">Fecha de Venta:</strong> {{ $venta->sale_date->format('d/m/Y H:i') }}</p> {{-- CAMBIO: created_at a sale_date --}}
                        <p class="mb-2"><strong class="font-semibold">Última Actualización:</strong> {{ $venta->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    {{-- Puedes añadir más detalles aquí si tu modelo de Venta tiene más campos --}}
                </div>

                <div class="mt-8">
                    <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">
                        {{ __('Productos en esta Venta') }}
                    </h4>
                    @if(isset($venta->products) && $venta->products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700 rounded-lg overflow-hidden">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Producto
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Cantidad
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Precio Unitario
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                            Subtotal
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($venta->products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $product->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $product->pivot->quantity ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{-- Usar product->pivot->unit_price --}}
                                                ${{ number_format($product->pivot->unit_price ?? $product->price, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{-- Usar product->pivot->unit_price para el cálculo del subtotal --}}
                                                ${{ number_format(($product->pivot->quantity ?? 1) * ($product->pivot->unit_price ?? $product->price), 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600 dark:text-gray-400">No hay productos asociados a esta venta.</p>
                    @endif
                </div>

                {{-- Botón "Regresar" llamativo --}}
                <div class="mt-8 text-center">
                    <a href="{{ route('ventas.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-wider shadow-lg hover:from-purple-700 hover:to-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-300 transform hover:scale-105">
                        <i class="bi bi-arrow-left-circle mr-3"></i>
                        {{ __('Regresar a Ventas') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>