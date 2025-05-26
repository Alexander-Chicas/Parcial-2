

<x-app-layout>
    {{-- Slot para el encabezado de la página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Usuario') }}
        </h2>
    </x-slot>

    {{-- Contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Título del formulario --}}
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">
                    {{ __('Formulario para Editar Usuario') }}
                </h3>

                {{-- Mensaje de éxito (si viene de una redirección) --}}
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 p-3 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Formulario para editar un usuario --}}
                <form action="{{ route('usuarios.update', $usuario->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Importante para las actualizaciones en Laravel --}}

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nombre</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $usuario->name) }}" required autofocus
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('name')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Email</label>
                        <input type="email" name="email" id="email" value="{{ old('email', $usuario->email) }}" required
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('email')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo para el Rol del Usuario --}}
                    <div class="mb-4">
                        <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Rol</label>
                        <select name="role" id="role" required
                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="admin" {{ old('role', $usuario->role) == 'admin' ? 'selected' : '' }}>Administrador</option>
                            <option value="employee" {{ old('role', $usuario->role) == 'employee' ? 'selected' : '' }}>Empleado</option>
                        </select>
                        @error('role')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Opcional: Campos para cambiar la contraseña.
                         Si no quieres permitir cambiar la contraseña desde aquí, puedes eliminar estos campos.
                         Si los dejas, asegúrate de que en el UserController el método update maneje la contraseña.
                    --}}
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nueva Contraseña (opcional)</label>
                        <input type="password" name="password" id="password" autocomplete="new-password"
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('password')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Confirmar Nueva Contraseña</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('password_confirmation')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Actualizar Usuario') }}
                        </button>
                    </div>
                </form>

                {{-- Botón "Regresar" llamativo --}}
                <div class="mt-8 text-center">
                    <a href="{{ route('usuarios.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-wider shadow-lg hover:from-purple-700 hover:to-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-300 transform hover:scale-105">
                        <i class="bi bi-arrow-left-circle mr-3"></i> {{-- Icono de flecha --}}
                        {{ __('Regresar a Usuarios') }}
                    </a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>