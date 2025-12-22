<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">
                    Editar Pérdida
                </h2>
                <p class="text-sm text-green-600 mt-1">Modifica los datos de la pérdida registrada</p>
            </div>
            <a href="{{ route('inventario.perdidas') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
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
                <form action="{{ route('inventario.perdidas.update', $perdida) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Producto -->
                        <div class="md:col-span-2">
                            <label for="producto_id" class="block text-sm font-medium text-gray-700">Producto *</label>
                            <select name="producto_id" id="producto_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                                <option value="">Selecciona un producto...</option>
                                @foreach($productos as $prod)
                                    <option value="{{ $prod->id }}" {{ old('producto_id', $perdida->producto_id) == $prod->id ? 'selected' : '' }}>
                                        {{ $prod->nombre }} 
                                        @if($prod->maneja_stock)
                                            (Stock: {{ number_format($prod->stock_actual, 2) }} {{ $prod->unidad_medida }})
                                        @else
                                            (Sin control de stock)
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('producto_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cantidad -->
                        <div>
                            <label for="cantidad" class="block text-sm font-medium text-gray-700">Cantidad Perdida *</label>
                            <input type="number" name="cantidad" id="cantidad" step="0.01" value="{{ old('cantidad', $perdida->cantidad) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="0.00">
                            @error('cantidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo de Pérdida -->
                        <div>
                            <label for="tipo_perdida" class="block text-sm font-medium text-gray-700">Tipo de Pérdida *</label>
                            <input type="text" name="tipo_perdida" id="tipo_perdida" value="{{ old('tipo_perdida', $perdida->tipo_perdida) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Ej: Humedad, Plaga, Derrame, Robo, etc.">
                            @error('tipo_perdida')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Escribe el tipo de pérdida</p>
                        </div>

                        <!-- Ubicación -->
                        <div>
                            <label for="ubicacion" class="block text-sm font-medium text-gray-700">Ubicación donde ocurrió</label>
                            <input type="text" name="ubicacion" id="ubicacion" value="{{ old('ubicacion', $perdida->ubicacion) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Ej: Bodega A">
                        </div>

                        <!-- Valor Estimado -->
                        <div>
                            <label for="valor_estimado" class="block text-sm font-medium text-gray-700">Valor Estimado de la Pérdida</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 sm:text-sm">$</span>
                                </div>
                                <input type="number" name="valor_estimado" id="valor_estimado" step="0.01" value="{{ old('valor_estimado', $perdida->valor_estimado) }}"
                                    class="pl-7 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                    placeholder="0.00">
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="md:col-span-2">
                            <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción Detallada</label>
                            <textarea name="descripcion" id="descripcion" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="Describe cómo ocurrió la pérdida...">{{ old('descripcion', $perdida->descripcion) }}</textarea>
                        </div>

                        <!-- Acciones Tomadas -->
                        <div class="md:col-span-2">
                            <label for="acciones_tomadas" class="block text-sm font-medium text-gray-700">Acciones Tomadas</label>
                            <textarea name="acciones_tomadas" id="acciones_tomadas" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                                placeholder="¿Qué se hizo al respecto? Ej: Se fumigó la bodega, se reparó el techo...">{{ old('acciones_tomadas', $perdida->acciones_tomadas) }}</textarea>
                        </div>

                        <!-- Foto Evidencia -->
                        <div class="md:col-span-2">
                            <label for="evidencia_foto" class="block text-sm font-medium text-gray-700">Foto de Evidencia</label>
                            
                            @if($perdida->evidencia_foto)
                                <div class="mt-2 mb-3">
                                    <p class="text-sm text-gray-600 mb-2">Foto actual:</p>
                                    <img src="{{ asset('storage/' . $perdida->evidencia_foto) }}" alt="Evidencia" class="h-32 w-auto rounded-lg border border-gray-300">
                                </div>
                            @endif
                            
                            <input type="file" name="evidencia_foto" id="evidencia_foto" accept="image/*"
                                class="mt-1 block w-full text-sm text-gray-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-md file:border-0
                                file:text-sm file:font-semibold
                                file:bg-orange-50 file:text-orange-700
                                hover:file:bg-orange-100">
                            <p class="text-xs text-gray-500 mt-1">Opcional: Sube una nueva foto para reemplazar la anterior</p>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-6 flex justify-end space-x-3">
                        <a href="{{ route('inventario.perdidas') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-6 py-2 rounded-md text-sm font-medium transition duration-200">
                            Cancelar
                        </a>
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-2 rounded-md text-sm font-medium transition duration-200">
                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Actualizar Pérdida
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
                        <p>Este registro es solo para <strong>documentación y control interno</strong> de las pérdidas.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

