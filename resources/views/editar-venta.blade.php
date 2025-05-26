

<x-app-layout>
    {{-- Slot para el encabezado de la página --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Venta') }}
        </h2>
    </x-slot>

    {{-- Contenido principal de la página --}}
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg p-6">

                {{-- Título del formulario --}}
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 text-center">
                    {{ __('Formulario para Editar Venta #') }}{{ $venta->id }}
                </h3>

                {{-- Mensaje de éxito o error --}}
                @if(session('success'))
                    <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-200 p-3 rounded-md mb-4">
                        {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="bg-red-100 dark:bg-red-800 text-red-800 dark:text-red-200 p-3 rounded-md mb-4">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- Formulario para editar una venta --}}
                <form action="{{ route('ventas.update', $venta->id) }}" method="POST">
                    @csrf
                    @method('PUT') {{-- Método PUT para actualizaciones --}}

                    {{-- Campo para seleccionar el Usuario --}}
                    <div class="mb-4">
                        <label for="user_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Usuario</label>
                        <select name="user_id" id="user_id" required
                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                            <option value="">Seleccione un usuario</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ old('user_id', $venta->user_id) == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }} ({{ $user->email }})
                                </option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Campo para la Fecha de Venta --}}
                    <div class="mb-6">
                        <label for="sale_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Fecha de Venta</label>
                        {{-- Formatear la fecha para el input datetime-local --}}
                        <input type="datetime-local" name="sale_date" id="sale_date" value="{{ old('sale_date', \Carbon\Carbon::parse($venta->sale_date)->format('Y-m-d\TH:i')) }}" required
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @error('sale_date')
                            <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Sección para añadir productos dinámicamente --}}
                    <h4 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-4">Productos de la Venta</h4>
                    <div id="product-items-container">
                        {{-- Los productos existentes se cargarán aquí con JavaScript --}}
                    </div>

                    <button type="button" id="add-product-button" class="inline-flex items-center px-4 py-2 bg-gray-200 dark:bg-gray-700 border border-transparent rounded-md font-semibold text-xs text-gray-700 dark:text-gray-200 uppercase tracking-widest hover:bg-gray-300 dark:hover:bg-gray-600 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mb-6">
                        <i class="bi bi-plus-circle mr-2"></i> {{ __('Añadir Producto') }}
                    </button>

                    {{-- Total de la Venta --}}
                    <div class="text-right text-2xl font-bold text-gray-900 dark:text-gray-100 mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                        Total de la Venta: <span id="grand-total-display">$0.00</span>
                    </div>

                    <div class="flex justify-end mt-6">
                        <button type="submit" class="inline-flex items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-base text-white uppercase tracking-widest shadow-lg hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Actualizar Venta') }}
                        </button>
                    </div>
                </form>

                {{-- Botón "Regresar" llamativo --}}
                <div class="mt-8 text-center">
                    <a href="{{ route('ventas.index') }}" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-purple-600 to-indigo-600 border border-transparent rounded-full font-bold text-lg text-white uppercase tracking-wider shadow-lg hover:from-purple-700 hover:to-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-300 transform hover:scale-105">
                        <i class="bi bi-arrow-left-circle mr-3"></i> {{ __('Regresar a Ventas') }}
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Convertir la colección de productos de Laravel a un objeto JavaScript para fácil acceso por ID
        const allProducts = @json($products);
        const productPrices = {};
        allProducts.forEach(product => {
            productPrices[product.id] = parseFloat(product.price);
        });

        let itemCounter = 0; // Para asegurar nombres únicos para los campos de entrada

        // Productos existentes en esta venta para precargar el formulario (ahora viene del controlador)
        const existingSaleItems = @json($existingSaleItems);

        /**
         * Añade una nueva fila para seleccionar un producto y su cantidad.
         * @param {Object} [itemData={}] - Datos del ítem de venta para precargar (opcional).
         */
        function addProductRow(itemData = {}) {
            const productItemsContainer = document.getElementById('product-items-container');
            const currentProductId = itemData.product_id || '';
            const currentQuantity = itemData.quantity || 1;
            // Usar el precio unitario del pivot si está disponible, de lo contrario, el precio actual del producto
            const currentUnitPrice = itemData.unit_price || productPrices[currentProductId] || 0;
            const currentSubtotal = currentUnitPrice * currentQuantity;

            const template = `
                <div class="flex flex-col md:flex-row items-start md:items-center space-y-2 md:space-y-0 md:space-x-4 mb-4 p-3 border border-gray-200 dark:border-gray-700 rounded-md product-item" data-item-id="${itemCounter}">
                    <div class="flex-1 w-full md:w-auto">
                        <label for="product_id_${itemCounter}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Producto</label>
                        <select name="products[${itemCounter}][product_id]" id="product_id_${itemCounter}"
                                class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm product-select" required>
                            <option value="">Seleccione un producto</option>
                            ${allProducts.map(product => `<option value="${product.id}" ${product.id == currentProductId ? 'selected' : ''}>${product.name} ($${parseFloat(product.price).toFixed(2)})</option>`).join('')}
                        </select>
                         {{-- Campo oculto para guardar el precio unitario en el momento de la venta --}}
                        <input type="hidden" name="products[${itemCounter}][unit_price]" class="unit-price-hidden" value="${currentUnitPrice.toFixed(2)}">
                    </div>
                    <div class="w-full md:w-24">
                        <label for="quantity_${itemCounter}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Cantidad</label>
                        <input type="number" name="products[${itemCounter}][quantity]" id="quantity_${itemCounter}" value="${currentQuantity}" min="1" required
                               class="block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm quantity-input">
                    </div>
                    <div class="w-full md:w-24">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Subtotal</label>
                        <span class="block px-3 py-2 text-gray-900 dark:text-gray-100 bg-gray-100 dark:bg-gray-700 rounded-md subtotal-display">$${currentSubtotal.toFixed(2)}</span>
                    </div>
                    <button type="button" class="mt-4 md:mt-0 text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-600 remove-product-row flex-shrink-0">
                        <i class="bi bi-x-circle-fill text-2xl"></i>
                    </button>
                </div>
            `;
            productItemsContainer.insertAdjacentHTML('beforeend', template);

            // Añadir event listeners para la nueva fila
            const newRow = productItemsContainer.lastElementChild;
            const productSelect = newRow.querySelector('.product-select');
            const quantityInput = newRow.querySelector('.quantity-input');
            const unitPriceHidden = newRow.querySelector('.unit-price-hidden');

            // Función para actualizar el precio unitario oculto y recalcular
            const updateUnitPriceAndCalculate = () => {
                const selectedProductId = productSelect.value;
                if (selectedProductId && productPrices[selectedProductId] !== undefined) {
                    unitPriceHidden.value = productPrices[selectedProductId].toFixed(2);
                } else {
                    unitPriceHidden.value = '0.00';
                }
                calculateTotals();
            };

            productSelect.addEventListener('change', updateUnitPriceAndCalculate);
            quantityInput.addEventListener('input', calculateTotals); // quantity input only needs to trigger calculateTotals

            // Al cargar una fila existente, si no hay unit_price en itemData, establecerlo desde productPrices
            if (!itemData.unit_price && currentProductId && productPrices[currentProductId] !== undefined) {
                 unitPriceHidden.value = productPrices[currentProductId].toFixed(2);
            }


            newRow.querySelector('.remove-product-row').addEventListener('click', function() {
                newRow.remove();
                calculateTotals(); // Recalcular totales después de eliminar una fila
            });

            itemCounter++;
            calculateTotals(); // Recalcular totales después de añadir una fila
        }

        /**
         * Calcula los subtotales de cada producto y el total general de la venta.
         */
        function calculateTotals() {
            let grandTotal = 0;
            const productItems = document.querySelectorAll('.product-item');

            productItems.forEach(item => {
                const productId = item.querySelector('.product-select').value;
                const quantityInput = item.querySelector('.quantity-input');
                const subtotalDisplay = item.querySelector('.subtotal-display');
                const unitPriceHidden = item.querySelector('.unit-price-hidden');

                let quantity = parseInt(quantityInput.value);
                if (isNaN(quantity) || quantity < 1) {
                    quantity = 1;
                    quantityInput.value = 1;
                }

                let price = parseFloat(unitPriceHidden.value); // Usar el valor del campo oculto como el precio base para el cálculo
                if (isNaN(price)) {
                    price = 0; // Si no hay precio válido, establecer a 0
                }

                const subtotal = price * quantity;
                subtotalDisplay.textContent = `$${subtotal.toFixed(2)}`;
                grandTotal += subtotal;
            });

            document.getElementById('grand-total-display').textContent = `$${grandTotal.toFixed(2)}`;
        }

        // Al cargar la página, precargar los productos existentes y configurar el botón "Añadir Producto"
        document.addEventListener('DOMContentLoaded', () => {
            if (existingSaleItems.length > 0) {
                existingSaleItems.forEach(item => addProductRow(item));
            } else {
                addProductRow(); // Añadir una fila vacía si no hay productos existentes
            }
            document.getElementById('add-product-button').addEventListener('click', addProductRow);
            calculateTotals(); // Calcular el total inicial
        });
    </script>
</x-app-layout>
