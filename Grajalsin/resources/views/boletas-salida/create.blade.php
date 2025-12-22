<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Registrar Boleta de Salida
                </h2>
                <p class="text-sm text-gray-600">Completa los datos finales después del pesaje</p>
            </div>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6 space-y-6">
        @if(session('warning'))
            <div class="px-4 py-3 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md text-sm">
                {{ session('warning') }}
            </div>
        @endif

        <form method="POST" action="{{ route('boletas-salida.store') }}" class="space-y-6">
            @csrf

            <!-- Seleccionar Orden de Carga -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 uppercase mb-3">Seleccionar Orden de Carga</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Orden de Carga</label>
                        <select name="orden_carga_id" id="orden_carga_id" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required onchange="if(this.value) window.location.href='{{ route('boletas-salida.create') }}?orden=' + this.value">
                            <option value="">-- Selecciona una orden --</option>
                            @foreach($ordenesDisponibles as $orden)
                                <option value="{{ $orden->id }}" {{ $ordenSeleccionada && $ordenSeleccionada->id == $orden->id ? 'selected' : '' }}>
                                    {{ $orden->folio }} - {{ $orden->operador_nombre }} - {{ $orden->destino }}
                                </option>
                            @endforeach
                        </select>
                        @error('orden_carga_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    @if($ordenSeleccionada)
                        <div class="text-sm text-green-700 font-semibold text-right">
                            Pre-carga desde {{ $ordenSeleccionada->folio }}
                        </div>
                    @endif
                </div>
            </div>

            @if($ordenSeleccionada)
                @php
                    $orden = $ordenSeleccionada;
                    $preOrden = $orden->preOrden;
                    $cliente = optional($preOrden)->cliente;
                    $chofer = optional($preOrden)->chofer;
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Datos Generales -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase">Datos Generales</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha</label>
                            <input type="date" name="fecha" value="{{ old('fecha', now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            @error('fecha')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente Tipo</label>
                            <input type="text" name="cliente_tipo" value="{{ old('cliente_tipo', 'PUBLICO EN GENERAL') }}" placeholder="Ej. PUBLICO EN GENERAL" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('cliente_tipo')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente Nombre *</label>
                            <input type="text" name="cliente_nombre" value="{{ old('cliente_nombre', optional($cliente)->nombre ?? optional($chofer)->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            @error('cliente_nombre')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Cliente RFC</label>
                            <input type="text" name="cliente_rfc" value="{{ old('cliente_rfc', optional($cliente)->rfc) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('cliente_rfc')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Producto *</label>
                            <input type="text" name="producto" value="{{ old('producto', $orden->producto) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            @error('producto')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Variedad</label>
                                <input type="text" name="variedad" value="{{ old('variedad') }}" placeholder="Ej. SINALOA" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('variedad')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Cosecha</label>
                                <input type="text" name="cosecha" value="{{ old('cosecha') }}" placeholder="Ej. UI 24-2025" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('cosecha')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Envase</label>
                            <input type="text" name="envase" value="{{ old('envase', $orden->presentacion ? ($orden->presentacion . ($orden->costal ? ' ' . $orden->costal : '')) : '') }}" placeholder="Ej. COSTAL 25 KGS" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('envase')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Origen</label>
                                <input type="text" name="origen" value="{{ old('origen', $orden->origen) }}" placeholder="Ej. GUAMUCHIL, SIN" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('origen')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Destino</label>
                                <input type="text" name="destino" value="{{ old('destino', $orden->destino) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('destino')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Referencia</label>
                            <input type="text" name="referencia" value="{{ old('referencia', $orden->referencia) }}" placeholder="Ej. FY" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('referencia')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <!-- Datos del Operador -->
                    <div class="space-y-4">
                        <h3 class="text-sm font-semibold text-gray-700 uppercase">Datos del Operador y Unidad</h3>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Operador *</label>
                            <input type="text" name="operador_nombre" value="{{ old('operador_nombre', $orden->operador_nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" required>
                            @error('operador_nombre')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Celular</label>
                                <input type="text" name="operador_celular" value="{{ old('operador_celular', $orden->operador_celular) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('operador_celular')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Licencia</label>
                                <input type="text" name="operador_licencia" value="{{ old('operador_licencia', $orden->operador_licencia) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('operador_licencia')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">RFC / CURP</label>
                            <input type="text" name="operador_curp" value="{{ old('operador_curp', $orden->operador_curp) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('operador_curp')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Camión</label>
                            <input type="text" name="camion" value="{{ old('camion', $orden->descripcion) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('camion')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Placas</label>
                            <input type="text" name="placas" value="{{ old('placas', $orden->placas_camion) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('placas')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Póliza</label>
                                <input type="text" name="poliza" value="{{ old('poliza', $orden->poliza) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('poliza')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Línea</label>
                                <input type="text" name="linea" value="{{ old('linea', $orden->linea) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('linea')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Análisis del Producto -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase mb-4">Análisis del Producto</h3>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Humedad (%)</label>
                            <input type="number" step="0.01" name="analisis_humedad" value="{{ old('analisis_humedad') }}" placeholder="Ej. 13.00" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('analisis_humedad')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">P. Específico</label>
                            <input type="number" step="0.01" name="analisis_peso_especifico" value="{{ old('analisis_peso_especifico') }}" placeholder="Ej. 760.00" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('analisis_peso_especifico')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Impurezas (%)</label>
                            <input type="number" step="0.01" name="analisis_impurezas" value="{{ old('analisis_impurezas') }}" placeholder="Ej. 0.40" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('analisis_impurezas')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quebrado (%)</label>
                            <input type="number" step="0.01" name="analisis_quebrado" value="{{ old('analisis_quebrado') }}" placeholder="Ej. 0.30" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('analisis_quebrado')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dañados (%)</label>
                            <input type="number" step="0.01" name="analisis_danados" value="{{ old('analisis_danados') }}" placeholder="Ej. 0.20" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('analisis_danados')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Otros (%)</label>
                            <input type="number" step="0.01" name="analisis_otros" value="{{ old('analisis_otros') }}" placeholder="Ej. 0.00" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('analisis_otros')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Peso Báscula -->
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase mb-4">Peso Báscula</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Peso Bruto</label>
                            <input type="number" step="0.01" name="peso_bruto" value="{{ old('peso_bruto') }}" placeholder="Ej. 46780" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('peso_bruto')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Peso Tara</label>
                            <input type="number" step="0.01" name="peso_tara" value="{{ old('peso_tara') }}" placeholder="Ej. 16780" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('peso_tara')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Peso Neto</label>
                            <input type="number" step="0.01" name="peso_neto" value="{{ old('peso_neto') }}" placeholder="Ej. 30000" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('peso_neto')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Peso Total</label>
                            <input type="number" step="0.01" name="peso_total" value="{{ old('peso_total') }}" placeholder="Ej. 30000" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                            @error('peso_total')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <!-- Observaciones y Firmas -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                            <textarea name="observaciones" rows="3" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500" placeholder="Ej. LLEVA 1500 COSTALES GRAJALSIN DE 25 KGS // TARIFA DE 700 X TON">{{ old('observaciones', $orden->observaciones) }}</textarea>
                            @error('observaciones')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Elaboró</label>
                                <input type="text" name="elaboro_nombre" value="{{ old('elaboro_nombre', auth()->user()->name) }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-700" readonly>
                                @error('elaboro_nombre')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Firma Recibió</label>
                                <input type="text" name="firma_recibio_nombre" value="{{ old('firma_recibio_nombre') }}" placeholder="Nombre de quien recibe" class="mt-1 block w-full rounded-md border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                                @error('firma_recibio_nombre')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                    <a href="{{ route('boletas-salida.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
                        Cancelar
                    </a>
                    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-blue-600 hover:to-blue-700 transition-all duration-200 transform hover:scale-105">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Guardar Boleta
                    </button>
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    <p class="text-lg">Selecciona una orden de carga para continuar</p>
                </div>
            @endif
        </form>
    </div>

    <style>
        .campo-vacio {
            border-color: #dc2626 !important;
            background-color: #fef2f2 !important;
        }
        .campo-vacio:focus {
            border-color: #dc2626 !important;
            ring-color: #dc2626 !important;
        }
    </style>

    <script>
        // Función para marcar campos vacíos con rojo
        function marcarCamposVacios() {
            const form = document.querySelector('form');
            if (!form) return;
            
            // Obtener todos los inputs, selects y textareas
            const campos = form.querySelectorAll('input:not([type="hidden"]):not([readonly]):not([disabled]), select:not([disabled]), textarea:not([disabled])');
            
            campos.forEach(campo => {
                // Remover clase anterior
                campo.classList.remove('campo-vacio');
                
                // Verificar si está vacío
                let vacio = false;
                if (campo.type === 'checkbox' || campo.type === 'radio') {
                    vacio = !campo.checked;
                } else if (campo.tagName === 'SELECT') {
                    vacio = !campo.value || campo.value === '';
                } else {
                    vacio = !campo.value || campo.value.trim() === '';
                }
                
                // Marcar si está vacío
                if (vacio) {
                    campo.classList.add('campo-vacio');
                }
            });
        }

        // Ejecutar al cargar la página
        document.addEventListener('DOMContentLoaded', function() {
            marcarCamposVacios();
            
            // Marcar campos vacíos cuando cambian
            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('input', function(e) {
                    const campo = e.target;
                    campo.classList.remove('campo-vacio');
                    if (!campo.value || campo.value.trim() === '') {
                        campo.classList.add('campo-vacio');
                    }
                });
                
                form.addEventListener('change', function(e) {
                    const campo = e.target;
                    campo.classList.remove('campo-vacio');
                    if (!campo.value || campo.value === '') {
                        campo.classList.add('campo-vacio');
                    }
                });
                
                // Marcar antes de enviar
                form.addEventListener('submit', function(e) {
                    marcarCamposVacios();
                });
            }
        });
    </script>
</x-app-layout>
