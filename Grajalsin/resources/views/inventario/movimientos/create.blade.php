<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">
                    Nuevo Movimiento
                </h2>
                <p class="text-sm text-green-600 mt-1">Registra una entrada o salida de inventario</p>
            </div>
            <a href="{{ route('inventario.movimientos') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
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
                <form action="{{ route('inventario.movimientos.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Producto -->
                        <div class="md:col-span-2">
                            <label for="producto_id" class="block text-sm font-medium text-gray-700">Producto *</label>
                            <select name="producto_id" id="producto_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Selecciona un producto...</option>
                                @foreach($productos as $prod)
                                    <option value="{{ $prod->id }}" {{ old('producto_id') == $prod->id ? 'selected' : '' }}>
                                        {{ $prod->nombre }} 
                                        @if($prod->maneja_stock)
                                            (Stock: {{ number_format($prod->stock_actual, 2) }} {{ $prod->unidad_medida }})
                                        @else
                                            (Bajo pedido)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('producto_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo -->
                        <div>
                            <label for="tipo" class="block text-sm font-medium text-gray-700">Tipo de Movimiento *</label>
                            <select name="tipo" id="tipo" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Selecciona...</option>
                                <option value="entrada" {{ old('tipo') == 'entrada' ? 'selected' : '' }}>➕ Entrada (Aumenta stock)</option>
                                <option value="salida" {{ old('tipo') == 'salida' ? 'selected' : '' }}>➖ Salida (Disminuye stock)</option>
                            </select>
                            @error('tipo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Motivo -->
                        <div>
                            <label for="motivo" class="block text-sm font-medium text-gray-700">Motivo *</label>
                            <select name="motivo" id="motivo" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Selecciona...</option>
                                <option value="compra" {{ old('motivo') == 'compra' ? 'selected' : '' }}>Compra a proveedor</option>
                                <option value="venta" {{ old('motivo') == 'venta' ? 'selected' : '' }}>Venta a cliente</option>
                                <option value="devolucion_cliente" {{ old('motivo') == 'devolucion_cliente' ? 'selected' : '' }}>Devolución de cliente</option>
                                <option value="devolucion_proveedor" {{ old('motivo') == 'devolucion_proveedor' ? 'selected' : '' }}>Devolución a proveedor</option>
                                <option value="ajuste_inventario" {{ old('motivo') == 'ajuste_inventario' ? 'selected' : '' }}>Ajuste de inventario</option>
                                <option value="transferencia" {{ old('motivo') == 'transferencia' ? 'selected' : '' }}>Transferencia entre bodegas</option>
                                <option value="otro" {{ old('motivo') == 'otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('motivo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cantidad -->
                        <div>
                            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad *</label>
                            <input type="number" name="cantidad" id="cantidad" step="0.01" value="{{ old('cantidad') }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="0.00">
                            @error('cantidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Precio Unitario -->
                        <div>
                            <label for="precio_unitario" class="block text-sm font-medium text-gray-700">Precio Unitario (opcional)</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="precio_unitario" id="precio_unitario" step="0.01" value="{{ old('precio_unitario') }}"
                                    class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                    placeholder="0.00">
                            </div>
                            @error('precio_unitario')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lote -->
                        <div>
                            <label for="lote" class="block text-sm font-medium text-gray-700">Lote (opcional)</label>
                            <input type="text" name="lote" id="lote" value="{{ old('lote') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Ej: LOTE-2024-001">
                        </div>

                        <!-- Referencia -->
                        <div>
                            <label for="referencia" class="block text-sm font-medium text-gray-700">Referencia (opcional)</label>
                            <input type="text" name="referencia" id="referencia" value="{{ old('referencia') }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Ej: Factura #1234">
                        </div>

                        <!-- Ubicación Origen -->
                        <div>
                            <label for="ubicacion_origen" class="block text-sm font-medium text-gray-700">Ubicación Origen</label>
                            <select name="ubicacion_origen" id="ubicacion_origen"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Selecciona una bodega...</option>
                                @foreach(\App\Models\Bodega::where('estatus', true)->orderBy('nombre')->get() as $bodega)
                                    <option value="{{ $bodega->nombre }}" {{ old('ubicacion_origen') == $bodega->nombre ? 'selected' : '' }}>
                                        {{ $bodega->nombre }}@if($bodega->ubicacion) - {{ $bodega->ubicacion }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">O deja vacío para escribir manualmente</p>
                        </div>

                        <!-- Ubicación Destino -->
                        <div>
                            <label for="ubicacion_destino" class="block text-sm font-medium text-gray-700">Ubicación Destino</label>
                            <select name="ubicacion_destino" id="ubicacion_destino"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Selecciona una bodega...</option>
                                @foreach(\App\Models\Bodega::where('estatus', true)->orderBy('nombre')->get() as $bodega)
                                    <option value="{{ $bodega->nombre }}" {{ old('ubicacion_destino') == $bodega->nombre ? 'selected' : '' }}>
                                        {{ $bodega->nombre }}@if($bodega->ubicacion) - {{ $bodega->ubicacion }}@endif
                                    </option>
                                @endforeach
                            </select>
                            <p class="text-xs text-gray-500 mt-1">O deja vacío para escribir manualmente</p>
                        </div>

                        <!-- Notas -->
                        <div class="md:col-span-2">
                            <label for="notas" class="block text-sm font-medium text-gray-700">Notas / Observaciones</label>
                            <textarea name="notas" id="notas" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Observaciones adicionales...">{{ old('notas') }}</textarea>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('inventario.movimientos') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition duration-200">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Registrar Movimiento
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Información -->
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800">Información</h3>
                    <div class="mt-2 text-sm text-blue-700">
                        <ul class="list-disc list-inside space-y-1">
                            <li><strong>Entrada:</strong> Aumenta el stock (compras, devoluciones de cliente)</li>
                            <li><strong>Salida:</strong> Disminuye el stock (ventas, devoluciones a proveedor)</li>
                            <li>Los productos <strong>bajo pedido</strong> no afectan el stock</li>
                            <li>El stock se actualiza automáticamente al guardar</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

