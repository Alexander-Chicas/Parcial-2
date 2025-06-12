<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panel de Control de la Microempresa') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">
                {{-- Título principal del dashboard, más moderno --}}
                <div class="text-center mb-10">
                    <h1 class="text-5xl font-extrabold text-gray-900 dark:text-gray-100 mb-4">📊 Gestión Integral de Negocio</h1>
                    <p class="text-lg text-gray-600 dark:text-gray-400">Todo lo que necesitas para tu microempresa en un solo lugar.</p>
                </div>

                {{-- Contenedor de las tarjetas con un grid responsivo y espacio entre ellas --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

                    {{-- Tarjeta de Usuarios --}}
                    <a href="{{ route('usuarios.index') }}" class="group relative flex flex-col items-center justify-center p-8 bg-gradient-to-br from-blue-500 to-blue-700 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out">
                        <i class="bi bi-people text-6xl text-white opacity-80 group-hover:opacity-100 transition-opacity duration-300"></i>
                        <h3 class="mt-4 text-3xl font-bold text-white text-center">Usuarios</h3>
                        <p class="mt-2 text-white text-opacity-80 text-center text-sm">Administra quién tiene acceso.</p>
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-xl"></div>
                    </a>

                    {{-- Tarjeta de Productos --}}
                    <a href="{{ route('productos.index') }}" class="group relative flex flex-col items-center justify-center p-8 bg-gradient-to-br from-green-500 to-green-700 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out">
                        <i class="bi bi-box-seam text-6xl text-white opacity-80 group-hover:opacity-100 transition-opacity duration-300"></i>
                        <h3 class="mt-4 text-3xl font-bold text-white text-center">Productos</h3>
                        <p class="mt-2 text-white text-opacity-80 text-center text-sm">Controla tu inventario con facilidad.</p>
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-xl"></div>
                    </a>

                    {{-- Tarjeta de Ventas --}}
                    <a href="{{ route('ventas.index') }}" class="group relative flex flex-col items-center justify-center p-8 bg-gradient-to-br from-purple-500 to-purple-700 rounded-xl shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 ease-in-out">
                        <i class="bi bi-cash-coin text-6xl text-white opacity-80 group-hover:opacity-100 transition-opacity duration-300"></i>
                        <h3 class="mt-4 text-3xl font-bold text-white text-center">Ventas</h3>
                        <p class="mt-2 text-white text-opacity-80 text-center text-sm">Monitorea tus ingresos y transacciones.</p>
                        <div class="absolute inset-0 bg-black opacity-0 group-hover:opacity-10 transition-opacity duration-300 rounded-xl"></div>
                    </a>

                  
                </div>
            </div>
        </div>
    </div>
</x-app-layout>