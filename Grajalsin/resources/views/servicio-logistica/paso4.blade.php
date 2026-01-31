<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-purple-800">
                    Paso 4: Monitoreo y Pago de Comisión
                </h2>
                <p class="text-sm text-purple-600 mt-1">Monitorear unidad y gestionar pago de comisión</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <div class="mb-4 p-4 bg-purple-50 rounded-lg">
                <p class="text-sm text-purple-800">
                    <strong>Folio:</strong> {{ $servicioLogistica->folio }} | 
                    <strong>Cliente:</strong> {{ $servicioLogistica->cliente->nombre }} | 
                    <strong>Tarifa:</strong> ${{ number_format($servicioLogistica->tarifa ?? 0, 2) }}
                    @if($servicioLogistica->comision_monto)
                        | <strong>Comisión:</strong> ${{ number_format($servicioLogistica->comision_monto, 2) }}
                    @endif
                </p>
            </div>

            <form action="{{ route('servicio-logistica.guardar-paso4', $servicioLogistica) }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Estado -->
                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-2">
                            Estado del Servicio <span class="text-red-500">*</span>
                        </label>
                        <select name="estado" id="estado" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="en_transito" {{ old('estado', $servicioLogistica->estado) == 'en_transito' ? 'selected' : '' }}>En Tránsito</option>
                            <option value="en_destino" {{ old('estado', $servicioLogistica->estado) == 'en_destino' ? 'selected' : '' }}>En Destino</option>
                            <option value="comision_pagada" {{ old('estado', $servicioLogistica->estado) == 'comision_pagada' ? 'selected' : '' }}>Comisión Pagada</option>
                            <option value="completado" {{ old('estado', $servicioLogistica->estado) == 'completado' ? 'selected' : '' }}>Completado</option>
                        </select>
                        @error('estado')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Fecha de Destino -->
                    <div>
                        <label for="fecha_destino" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Llegada a Destino
                        </label>
                        <input type="date" name="fecha_destino" id="fecha_destino"
                            value="{{ old('fecha_destino', $servicioLogistica->fecha_destino ? $servicioLogistica->fecha_destino->format('Y-m-d') : '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        @error('fecha_destino')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comisión Pagada -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="comision_pagada" value="1" 
                                {{ old('comision_pagada', $servicioLogistica->comision_pagada) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm text-gray-700">Comisión Pagada</span>
                        </label>
                    </div>

                    <!-- Fecha de Pago de Comisión -->
                    <div>
                        <label for="fecha_pago_comision" class="block text-sm font-medium text-gray-700 mb-2">
                            Fecha de Pago de Comisión
                        </label>
                        <input type="date" name="fecha_pago_comision" id="fecha_pago_comision"
                            value="{{ old('fecha_pago_comision', $servicioLogistica->fecha_pago_comision ? $servicioLogistica->fecha_pago_comision->format('Y-m-d') : '') }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        @error('fecha_pago_comision')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Notas de Monitoreo -->
                    <div>
                        <label for="notas_monitoreo" class="block text-sm font-medium text-gray-700 mb-2">
                            Notas de Monitoreo
                        </label>
                        <textarea name="notas_monitoreo" id="notas_monitoreo" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">{{ old('notas_monitoreo', $servicioLogistica->notas_monitoreo) }}</textarea>
                        @error('notas_monitoreo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between pt-4 border-t">
                        <a href="{{ route('servicio-logistica.show', $servicioLogistica) }}" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Volver
                        </a>
                        <button type="submit" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm font-medium hover:bg-purple-700">
                            Guardar Estado
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

