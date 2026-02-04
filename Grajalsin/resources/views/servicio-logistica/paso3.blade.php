<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-purple-800">
                    Paso 3: Preparar Orden de Carga
                </h2>
                <p class="text-sm text-purple-600 mt-1">Completar formato DATOS DE CARGA</p>
            </div>
            <a href="{{ route('servicio-logistica.print', $servicioLogistica) }}" target="_blank" 
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Ver Formato
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <div class="mb-4 p-4 bg-purple-50 rounded-lg">
                <p class="text-sm text-purple-800">
                    <strong>Folio:</strong> {{ $servicioLogistica->folio }} | 
                    <strong>Cliente:</strong> {{ $servicioLogistica->cliente->nombre }} | 
                    <strong>Línea:</strong> {{ $servicioLogistica->lineaCarga->nombre ?? '-' }} | 
                    <strong>Tarifa:</strong> ${{ number_format($servicioLogistica->tarifa ?? 0, 2) }}
                </p>
            </div>

            <form action="{{ route('servicio-logistica.guardar-paso3', $servicioLogistica) }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Datos del Operador -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-lg text-purple-800 border-b pb-2">Datos del Operador</h3>
                        
                        <div>
                            <label for="chofer_id" class="block text-sm font-medium text-gray-700 mb-1">Chofer</label>
                            <select name="chofer_id" id="chofer_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Seleccione un chofer</option>
                                @foreach($choferes as $chofer)
                                    <option value="{{ $chofer->id }}" {{ old('chofer_id', $servicioLogistica->chofer_id) == $chofer->id ? 'selected' : '' }}>
                                        {{ $chofer->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="operador_nombre" class="block text-sm font-medium text-gray-700 mb-1">Operador <span class="text-red-500">*</span></label>
                            <input type="text" name="operador_nombre" id="operador_nombre" required
                                value="{{ old('operador_nombre', $servicioLogistica->operador_nombre) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="operador_celular" class="block text-sm font-medium text-gray-700 mb-1">No. Celular</label>
                            <input type="text" name="operador_celular" id="operador_celular"
                                value="{{ old('operador_celular', $servicioLogistica->operador_celular) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="operador_licencia_numero" class="block text-sm font-medium text-gray-700 mb-1">Número de Licencia</label>
                            <input type="text" name="operador_licencia_numero" id="operador_licencia_numero"
                                value="{{ old('operador_licencia_numero', $servicioLogistica->operador_licencia_numero) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="operador_curp_rfc" class="block text-sm font-medium text-gray-700 mb-1">CURP y/o RFC</label>
                            <input type="text" name="operador_curp_rfc" id="operador_curp_rfc"
                                value="{{ old('operador_curp_rfc', $servicioLogistica->operador_curp_rfc) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>

                    <!-- Datos del Vehículo y Carga -->
                    <div class="space-y-4">
                        <h3 class="font-semibold text-lg text-purple-800 border-b pb-2">Datos del Vehículo</h3>
                        
                        <div>
                            <label for="placa_tractor" class="block text-sm font-medium text-gray-700 mb-1">Placa de tractor</label>
                            <input type="text" name="placa_tractor" id="placa_tractor"
                                value="{{ old('placa_tractor', $servicioLogistica->placa_tractor) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="placa_remolque" class="block text-sm font-medium text-gray-700 mb-1">Placa del remolque</label>
                            <input type="text" name="placa_remolque" id="placa_remolque"
                                value="{{ old('placa_remolque', $servicioLogistica->placa_remolque) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="modelo_color" class="block text-sm font-medium text-gray-700 mb-1">Modelo y color</label>
                            <input type="text" name="modelo_color" id="modelo_color"
                                value="{{ old('modelo_color', $servicioLogistica->modelo_color) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="poliza_compania" class="block text-sm font-medium text-gray-700 mb-1">Póliza / Compañía</label>
                            <input type="text" name="poliza_compania" id="poliza_compania"
                                value="{{ old('poliza_compania', $servicioLogistica->poliza_compania) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <h3 class="font-semibold text-lg text-purple-800 border-b pb-2 mt-6">Datos de la Carga</h3>

                        <div>
                            <label for="destino_id" class="block text-sm font-medium text-gray-700 mb-1">Destino</label>
                            <select name="destino_id" id="destino_id"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                                <option value="">Seleccione un destino</option>
                                @foreach($destinos as $destino)
                                    <option value="{{ $destino->id }}" {{ old('destino_id', $servicioLogistica->destino_id) == $destino->id ? 'selected' : '' }}>
                                        {{ $destino->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="destino_carga" class="block text-sm font-medium text-gray-700 mb-1">Destino de la Carga</label>
                            <input type="text" name="destino_carga" id="destino_carga"
                                value="{{ old('destino_carga', $servicioLogistica->destino_carga) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="bodega" class="block text-sm font-medium text-gray-700 mb-1">Bodega</label>
                            <input type="text" name="bodega" id="bodega"
                                value="{{ old('bodega', $servicioLogistica->bodega) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="criba" class="block text-sm font-medium text-gray-700 mb-1">Criba</label>
                            <input type="text" name="criba" id="criba"
                                value="{{ old('criba', $servicioLogistica->criba) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="cliente_empresa" class="block text-sm font-medium text-gray-700 mb-1">Cliente / Empresa</label>
                            <input type="text" name="cliente_empresa" id="cliente_empresa"
                                value="{{ old('cliente_empresa', $servicioLogistica->cliente_empresa ?? $servicioLogistica->cliente->nombre) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="coordinador_nombre" class="block text-sm font-medium text-gray-700 mb-1">Coordinador</label>
                            <input type="text" name="coordinador_nombre" id="coordinador_nombre"
                                value="{{ old('coordinador_nombre', $servicioLogistica->coordinador_nombre) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="coordinador_numero" class="block text-sm font-medium text-gray-700 mb-1">Número</label>
                            <input type="text" name="coordinador_numero" id="coordinador_numero"
                                value="{{ old('coordinador_numero', $servicioLogistica->coordinador_numero) }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="fecha" class="block text-sm font-medium text-gray-700 mb-1">Fecha</label>
                            <input type="date" name="fecha" id="fecha"
                                value="{{ old('fecha', $servicioLogistica->fecha ? $servicioLogistica->fecha->format('Y-m-d') : '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>

                        <div>
                            <label for="fecha_carga" class="block text-sm font-medium text-gray-700 mb-1">Fecha de Carga</label>
                            <input type="date" name="fecha_carga" id="fecha_carga"
                                value="{{ old('fecha_carga', $servicioLogistica->fecha_carga ? $servicioLogistica->fecha_carga->format('Y-m-d') : '') }}"
                                class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                        </div>
                    </div>
                </div>

                <!-- Información Interna -->
                <div class="mt-6 space-y-4 border-t pt-6">
                    <h3 class="font-semibold text-lg text-purple-800">Información Interna</h3>
                    
                    <div>
                        <label for="clave_interna" class="block text-sm font-medium text-gray-700 mb-1">Clave Interna</label>
                        <input type="text" name="clave_interna" id="clave_interna"
                            value="{{ old('clave_interna', $servicioLogistica->clave_interna) }}"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                    </div>

                    <div>
                        <label for="notas_internas" class="block text-sm font-medium text-gray-700 mb-1">Notas Internas</label>
                        <textarea name="notas_internas" id="notas_internas" rows="3"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">{{ old('notas_internas', $servicioLogistica->notas_internas) }}</textarea>
                    </div>
                </div>

                <!-- Botones -->
                <div class="flex justify-between pt-4 border-t mt-6">
                    <a href="{{ route('servicio-logistica.paso2', $servicioLogistica) }}" 
                        class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                        Volver
                    </a>
                    <button type="submit" 
                        class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm font-medium hover:bg-purple-700">
                        Guardar y Continuar
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

