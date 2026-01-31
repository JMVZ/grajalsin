<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-purple-800">
                    Paso 5: Carga de Retorno
                </h2>
                <p class="text-sm text-purple-600 mt-1">Gestionar carga de retorno al origen</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <div class="mb-4 p-4 bg-purple-50 rounded-lg">
                <p class="text-sm text-purple-800">
                    <strong>Folio:</strong> {{ $servicioLogistica->folio }} | 
                    <strong>Cliente:</strong> {{ $servicioLogistica->cliente->nombre }} | 
                    <strong>Destino:</strong> {{ $servicioLogistica->destino_carga ?? ($servicioLogistica->destino->nombre ?? '-') }}
                </p>
            </div>

            <form action="{{ route('servicio-logistica.guardar-paso5', $servicioLogistica) }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Tiene Carga de Retorno -->
                    <div>
                        <label class="flex items-center">
                            <input type="checkbox" name="tiene_carga_retorno" value="1" 
                                {{ old('tiene_carga_retorno', $servicioLogistica->tiene_carga_retorno) ? 'checked' : '' }}
                                onchange="toggleRetorno(this)"
                                class="rounded border-gray-300 text-purple-600 focus:ring-purple-500">
                            <span class="ml-2 text-sm font-medium text-gray-700">Tiene Carga de Retorno</span>
                        </label>
                    </div>

                    <!-- Servicio de Retorno -->
                    <div id="retorno-fields" style="display: {{ old('tiene_carga_retorno', $servicioLogistica->tiene_carga_retorno) ? 'block' : 'none' }};">
                        <label for="servicio_retorno_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Servicio de Retorno (Opcional)
                        </label>
                        <select name="servicio_retorno_id" id="servicio_retorno_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Seleccione un servicio de retorno</option>
                            @foreach($serviciosDisponibles as $servicio)
                                <option value="{{ $servicio->id }}" {{ old('servicio_retorno_id', $servicioLogistica->servicio_retorno_id) == $servicio->id ? 'selected' : '' }}>
                                    {{ $servicio->folio }} - {{ $servicio->cliente->nombre }} ({{ $servicio->destino_carga ?? '-' }})
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Puede vincular un servicio existente o crear uno nuevo</p>
                    </div>

                    <!-- Notas de Retorno -->
                    <div>
                        <label for="notas_retorno" class="block text-sm font-medium text-gray-700 mb-2">
                            Notas de Retorno
                        </label>
                        <textarea name="notas_retorno" id="notas_retorno" rows="4"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">{{ old('notas_retorno', $servicioLogistica->notas_retorno) }}</textarea>
                        @error('notas_retorno')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Información -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <p class="text-sm text-blue-800">
                            <strong>Nota:</strong> Si necesita crear un nuevo servicio de retorno, puede hacerlo desde el menú principal. 
                            Luego podrá vincularlo aquí.
                        </p>
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-between pt-4 border-t">
                        <a href="{{ route('servicio-logistica.show', $servicioLogistica) }}" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Volver
                        </a>
                        <button type="submit" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm font-medium hover:bg-purple-700">
                            Guardar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleRetorno(checkbox) {
            const fields = document.getElementById('retorno-fields');
            fields.style.display = checkbox.checked ? 'block' : 'none';
        }
    </script>
</x-app-layout>

