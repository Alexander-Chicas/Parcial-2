<div class="bg-red-600 rounded-lg shadow-lg p-6 text-white flex flex-col items-center justify-center relative cursor-pointer"
     x-data="{ open: false }" @click.away="open = false" @click="open = !open"> {{-- x-data y @click para Alpine.js --}}
    <div class="text-5xl mb-2">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <div class="text-2xl font-semibold mb-1">
        Alertas
    </div>
    <p class="text-sm text-red-100 mb-4">
        Notificaciones importantes para tu negocio.
    </p>

    {{-- Contador de Alertas no leídas (la burbuja roja) --}}
    @if ($alertCount > 0)
        <span class="absolute top-2 right-2 bg-white text-red-600 text-xs font-bold px-2 py-1 rounded-full animate-bounce">
            {{ $alertCount }}
        </span>
    @endif

    {{-- Panel de Alertas Desplegable (usa Alpine.js x-show) --}}
    <div x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform scale-95"
         x-transition:enter-end="opacity-100 transform scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform scale-100"
         x-transition:leave-end="opacity-0 transform scale-95"
         class="absolute top-full mt-2 w-80 bg-gray-800 rounded-lg shadow-xl z-30 right-0">
        <div class="py-2">
            <h3 class="text-lg font-semibold px-4 py-2 border-b border-gray-700 text-gray-200">
                Notificaciones ({{ $alerts->count() }})
            </h3>
            @forelse ($alerts as $alert)
                <div class="px-4 py-3 border-b border-gray-700 {{ $alert->is_read ? 'bg-gray-700 text-gray-400' : 'bg-gray-800 text-white hover:bg-gray-700' }} transition-colors duration-200">
                    <div class="flex items-start">
                        <i class="{{ $alert->icon ?? 'fas fa-bell' }} text-{{ $alert->type === 'danger' ? 'red-500' : ($alert->type === 'warning' ? 'yellow-500' : ($alert->type === 'info' ? 'blue-500' : 'green-500')) }} text-xl mr-3 mt-1"></i>
                        <div class="flex-grow">
                            <p class="font-medium text-sm">
                                {{ $alert->message }}
                            </p>
                            @if (!$alert->is_read)
                                <button wire:click="markAsRead({{ $alert->id }})" class="mt-1 text-xs text-blue-400 hover:underline">
                                    Marcar como leída
                                </button>
                            @endif
                        </div>
                        @if ($alert->product)
                            {{-- ¡CAMBIO AQUÍ! products.edit -> productos.edit --}}
                            <a href="{{ route('productos.edit', $alert->product->id) }}" class="text-gray-400 hover:text-white ml-2 text-sm" title="Ir al producto">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <p class="px-4 py-3 text-sm text-gray-400">No tienes alertas activas en este momento.</p>
            @endforelse
            <div class="px-4 py-2 border-t border-gray-700">
                {{-- ¡CAMBIO AQUÍ! products.index -> productos.index --}}
                <a href="{{ route('productos.index') }}" class="block text-center text-blue-400 hover:underline text-sm">Gestionar Inventario</a>
            </div>
        </div>
    </div>
</div>