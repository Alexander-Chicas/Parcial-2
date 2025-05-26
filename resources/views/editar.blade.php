<x-app-layout>
    {{-- Slot para el encabezado de la página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Producto') }}
        </h2>
    </x-slot>

    {{-- Contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Título del formulario --}}
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">
                    {{ __('Formulario para Editar Producto') }}
                </h3>

                {{-- Mensaje de éxito (si viene de una redirección) --}}
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 p-3 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 p-3 rounded-md mb-4">
                        {{ session('error') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 p-3 rounded-md mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulario para editar un producto --}}
                <form action="{{ route('productos.update', $producto->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Importante para las actualizaciones en Laravel --}}

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre del Producto</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $producto->name) }}" required autofocus
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Descripción</label>
                        <textarea name="description" id="description" rows="3"
                                  class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">{{ old('description', $producto->description) }}</textarea>
                        @error('description')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Precio</label>
                        <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $producto->price) }}" required
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('price')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="stock" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock</label>
                        <input type="number" name="stock" id="stock" value="{{ old('stock', $producto->stock) }}" required
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('stock')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Actualizar Producto') }}
                        </button>
                    </div>
                </form>

                {{-- Botón "Regresar" llamativo --}}
                <div class="mt-8 text-center">
                    <a href="{{ route('productos.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-wider shadow-lg hover:from-purple-700 hover:to-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-300 transform hover:scale-105">
                        <i class="bi bi-arrow-left-circle mr-3"></i> {{ __('Regresar a Productos') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
