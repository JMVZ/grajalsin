<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">
                    Nuevo Producto
                </h2>
                <p class="text-sm text-green-600 mt-1">Registra un nuevo producto o grano</p>
            </div>
            <a href="{{ route('inventario.productos') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Volver
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white shadow rounded-lg border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <form action="{{ route('inventario.productos.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre del Producto *</label>
                            <input type="text" name="nombre" id="nombre" value="{{ old('nombre') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('nombre')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Código -->
                        <div>
                            <label for="codigo" class="block text-sm font-medium text-gray-700">Código (opcional)</label>
                            <input type="text" name="codigo" id="codigo" value="{{ old('codigo') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            @error('codigo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Descripción -->
                        <div class="md:col-span-2">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción</label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('descripcion') }}</textarea>
                            @error('descripcion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Unidad de medida -->
                        <div>
                            <label for="unidad_medida" class="block text-sm font-medium text-gray-700">Unidad de Medida *</label>
                            <select name="unidad_medida" id="unidad_medida" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="kg" {{ old('unidad_medida') == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                                <option value="quintal" {{ old('unidad_medida') == 'quintal' ? 'selected' : '' }}>Quintales</option>
                                <option value="costal" {{ old('unidad_medida') == 'costal' ? 'selected' : '' }}>Costales</option>
                                <option value="tonelada" {{ old('unidad_medida') == 'tonelada' ? 'selected' : '' }}>Toneladas</option>
                                <option value="libra" {{ old('unidad_medida') == 'libra' ? 'selected' : '' }}>Libras</option>
                            </select>
                            @error('unidad_medida')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Maneja Stock -->
                        <div class="md:col-span-2">
                            <div class="flex items-start">
                                <div class="flex items-center h-5">
                                    <!-- Campo oculto para enviar 0 cuando está desmarcado -->
                                    <input type="hidden" name="maneja_stock" value="0">
                                    <input id="maneja_stock" name="maneja_stock" type="checkbox" value="1" 
                                        {{ old('maneja_stock', true) ? 'checked' : '' }}
                                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                        onclick="toggleStockFields()">
                                </div>
                                <div class="ml-3 text-sm">
                                    <label for="maneja_stock" class="font-medium text-gray-700">¿Maneja Stock?</label>
                                    <p class="text-gray-500">Desmarca si el producto es <strong>bajo pedido</strong> (siempre disponible)</p>
                                </div>
                            </div>
                        </div>

                        <!-- Campos de Stock (solo si maneja stock) -->
                        <div id="stock-fields" class="md:col-span-2 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="stock_actual" class="block text-sm font-medium text-gray-700">Stock Actual</label>
                                <input type="number" name="stock_actual" id="stock_actual" step="0.01" value="{{ old('stock_actual', 0) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            <div>
                                <label for="stock_minimo" class="block text-sm font-medium text-gray-700">Stock Mínimo (Alerta)</label>
                                <input type="number" name="stock_minimo" id="stock_minimo" step="0.01" value="{{ old('stock_minimo') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>

                            <div>
                                <label for="stock_maximo" class="block text-sm font-medium text-gray-700">Stock Máximo</label>
                                <input type="number" name="stock_maximo" id="stock_maximo" step="0.01" value="{{ old('stock_maximo') }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                        </div>

                        <!-- Precios -->
                        <div>
                            <label for="precio_compra" class="block text-sm font-medium text-gray-700">Precio de Compra</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="precio_compra" id="precio_compra" step="0.01" value="{{ old('precio_compra') }}"
                                    class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                        </div>

                        <div>
                            <label for="precio_venta" class="block text-sm font-medium text-gray-700">Precio de Venta</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="precio_venta" id="precio_venta" step="0.01" value="{{ old('precio_venta') }}"
                                    class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                            </div>
                        </div>

                        <!-- Ubicación -->
                        <div>
                            <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación / Bodega</label>
                            <select name="ubicacion" id="ubicacion"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Selecciona una bodega...</option>
                                @foreach(\App\Models\Bodega::where('estatus', true)->orderBy('nombre')->get() as $bodega)
                                    <option value="{{ $bodega->nombre }}" {{ old('ubicacion') == $bodega->nombre ? 'selected' : '' }}>
                                        {{ $bodega->nombre }}@if($bodega->ubicacion) - {{ $bodega->ubicacion }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">O deja vacío para escribir manualmente</p>
                        </div>

                        <!-- Imagen -->
                        <div>
                            <label for="imagen" class="block text-sm font-medium text-gray-700">Imagen del Producto</label>
                            <input type="file" name="imagen" id="imagen" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-green-50 file:text-green-700
                                hover:file:bg-green-100">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('inventario.productos') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition duration-200">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Guardar Producto
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleStockFields() {
            const manejaStock = document.getElementById('maneja_stock').checked;
            const stockFields = document.getElementById('stock-fields');
            const stockActual = document.getElementById('stock_actual');
            const stockMinimo = document.getElementById('stock_minimo');
            const stockMaximo = document.getElementById('stock_maximo');
            
            if (manejaStock) {
                stockFields.style.display = 'grid';
            } else {
                stockFields.style.display = 'none';
                // Poner en 0 los campos de stock cuando no maneja stock
                stockActual.value = '0';
                stockMinimo.value = '';
                stockMaximo.value = '';
            }
        }

        // Ejecutar al cargar la página
        toggleStockFields();
    </script>
</x-app-layout>

