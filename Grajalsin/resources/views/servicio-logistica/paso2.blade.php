<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-purple-800">
                    Paso 2: Contactar Línea de Transporte
                </h2>
                <p class="text-sm text-purple-600 mt-1">Acordar tarifa y comisión con la línea de transporte</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <div class="mb-4 p-4 bg-purple-50 rounded-lg">
                <p class="text-sm text-purple-800">
                    <strong>Folio:</strong> {{ $servicioLogistica->folio }} | 
                    <strong>Cliente:</strong> {{ $servicioLogistica->cliente->nombre }} | 
                    <strong>Tipo Unidad:</strong> {{ $servicioLogistica->tipo_unidad_nombre }}
                </p>
            </div>

            <form action="{{ route('servicio-logistica.guardar-paso2', $servicioLogistica) }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Línea de Carga -->
                    <div>
                        <label for="linea_carga_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Línea de Transporte <span class="text-red-500">*</span>
                        </label>
                        <select name="linea_carga_id" id="linea_carga_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Seleccione una línea</option>
                            @foreach($lineasCarga as $linea)
                                <option value="{{ $linea->id }}" {{ old('linea_carga_id', $servicioLogistica->linea_carga_id) == $linea->id ? 'selected' : '' }}>
                                    {{ $linea->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('linea_carga_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tarifa -->
                    <div>
                        <label for="tarifa" class="block text-sm font-medium text-gray-700 mb-2">
                            Tarifa <span class="text-red-500">*</span>
                        </label>
                        <input type="number" name="tarifa" id="tarifa" step="0.01" min="0" required
                            value="{{ old('tarifa', $servicioLogistica->tarifa) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        @error('tarifa')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Comisión Porcentaje -->
                    <div>
                        <label for="comision_porcentaje" class="block text-sm font-medium text-gray-700 mb-2">
                            Comisión (%) <span class="text-gray-500">(Opcional)</span>
                        </label>
                        <input type="number" name="comision_porcentaje" id="comision_porcentaje" step="0.01" min="0" max="100"
                            value="{{ old('comision_porcentaje', $servicioLogistica->comision_porcentaje) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500"
                            onchange="calcularComision()">
                        @error('comision_porcentaje')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-sm text-gray-500" id="comision-monto"></p>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between pt-4 border-t">
                        <a href="{{ route('servicio-logistica.index') }}" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </a>
                        <button type="submit" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm font-medium hover:bg-purple-700">
                            Continuar al Paso 3
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function calcularComision() {
            const tarifa = parseFloat(document.getElementById('tarifa').value) || 0;
            const porcentaje = parseFloat(document.getElementById('comision_porcentaje').value) || 0;
            const monto = (tarifa * porcentaje) / 100;
            document.getElementById('comision-monto').textContent = 
                porcentaje > 0 ? `Monto de comisión: $${monto.toFixed(2)}` : '';
        }
        document.getElementById('tarifa').addEventListener('input', calcularComision);
    </script>
</x-app-layout>

