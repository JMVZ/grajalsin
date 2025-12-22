<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Orden de Carga
        </h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6 space-y-6">
        @if(session('warning'))
            <div class="px-4 py-3 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded-md text-sm">
                {{ session('warning') }}
            </div>
        @endif

        <form method="POST" action="{{ route('ordenes-carga.store') }}" class="space-y-6">
            @csrf

            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-700 uppercase mb-3">Seleccionar Pre-orden</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 items-end">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700">Pre-orden</label>
                        <select name="pre_orden_id" id="pre_orden_id" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500" required onchange="if(this.value) window.location.href='{{ route('ordenes-carga.create') }}?pre_orden=' + this.value">
                            <option value="">-- Selecciona una pre-orden --</option>
                            @foreach($preOrdenesDisponibles as $po)
                                <option value="{{ $po->id }}" {{ $preOrdenSeleccionada && $preOrdenSeleccionada->id == $po->id ? 'selected' : '' }}>
                                    {{ $po->folio }} - {{ optional($po->chofer)->nombre }} - {{ optional($po->destino)->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('pre_orden_id')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                    @if($preOrdenSeleccionada)
                        <div class="text-sm text-green-700 font-semibold text-right">
                            Datos precargados de {{ $preOrdenSeleccionada->folio }}
                        </div>
                    @endif
                </div>
            </div>

            @php
                $productosTexto = '';
                $presentacion = '';
                $costalDescripcion = '';
                $pesoTexto = '';

                if($preOrdenSeleccionada) {
                    $productos = $preOrdenSeleccionada->productos;
                    if($productos->count() > 0) {
                        if($productos->count() === 1) {
                            $producto = $productos->first();
                            if($producto->pivot->tipo_carga === 'granel') {
                                $presentacion = 'Granel';
                                $pesoTexto = trim(($producto->pivot->toneladas ?? 0) . ' ton');
                                $productosTexto = strtoupper($producto->nombre);
                            } else {
                                $presentacion = 'Costal';
                                $cantidad = $producto->pivot->cantidad ?? 0;
                                $productosTexto = strtoupper($producto->nombre);
                                $costalDescripcion = $cantidad . ' uds';
                            }
                        } else {
                            $productosTexto = strtoupper($productos->pluck('nombre')->implode(', '));
                            $presentacion = 'Mixto';
                        }
                    }
                }
            @endphp

            @php
                $preChofer = optional(optional($preOrdenSeleccionada)->chofer);
                $preLinea = optional(optional($preOrdenSeleccionada)->lineaCarga);
                $preDestino = optional(optional($preOrdenSeleccionada)->destino);
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase">Datos generales</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de entrada</label>
                        <input type="date" name="fecha_entrada" value="{{ old('fecha_entrada', optional(optional($preOrdenSeleccionada)->fecha)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                        @error('fecha_entrada')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Origen</label>
                        <input type="text" name="origen" value="{{ old('origen') }}" placeholder="Ej. Guamúchil" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('origen')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Bodega</label>
                        <select name="bodega" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            <option value="">Selecciona una bodega...</option>
                            @foreach(\App\Models\Bodega::where('estatus', true)->orderBy('nombre')->get() as $bodega)
                                <option value="{{ $bodega->nombre }}" {{ old('bodega', optional($preOrdenSeleccionada)->base_linea ?? '') == $bodega->nombre ? 'selected' : '' }}>
                                    {{ $bodega->nombre }}@if($bodega->ubicacion) - {{ $bodega->ubicacion }}@endif
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">O deja vacío para escribir manualmente</p>
                        @error('bodega')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Destino</label>
                        <input type="text" name="destino" value="{{ old('destino', $preDestino->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('destino')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Peso</label>
                        <input type="text" name="peso" value="{{ old('peso', $pesoTexto) }}" placeholder="Ej. 25 ton" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('peso')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Producto</label>
                        <input type="text" name="producto" value="{{ old('producto', $productosTexto) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('producto')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Presentación</label>
                            <input type="text" name="presentacion" value="{{ old('presentacion', $presentacion) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('presentacion')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Costal</label>
                            <input type="text" name="costal" value="{{ old('costal', $costalDescripcion) }}" placeholder="Ej. Rojo Rama" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('costal')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                        <textarea name="observaciones" rows="3" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">{{ old('observaciones', optional($preOrdenSeleccionada)->notas ?? '') }}</textarea>
                        @error('observaciones')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-gray-700 uppercase">Datos de Operador</h3>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Operador</label>
                        <input type="text" name="operador_nombre" value="{{ old('operador_nombre', $preChofer->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500" required>
                        @error('operador_nombre')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Celular</label>
                            <input type="text" name="operador_celular" value="{{ old('operador_celular', $preChofer->telefono) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('operador_celular')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Licencia</label>
                            <input type="text" name="operador_licencia" value="{{ old('operador_licencia', $preChofer->licencia_numero) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('operador_licencia')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">RFC / CURP</label>
                        <input type="text" name="operador_curp" value="{{ old('operador_curp', $preChofer->curp) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('operador_curp')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Placas camión</label>
                        @php
                            $placas = $preOrdenSeleccionada ? trim(($preOrdenSeleccionada->placa_tractor ?? '') . ' - ' . ($preOrdenSeleccionada->placa_remolque ?? '')) : '';
                        @endphp
                        <input type="text" name="placas_camion" value="{{ old('placas_camion', trim($placas, ' -')) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('placas_camion')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Descripción (vehículo)</label>
                        <input type="text" name="descripcion" value="{{ old('descripcion', optional($preOrdenSeleccionada)->modelo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('descripcion')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Línea</label>
                            <input type="text" name="linea" value="{{ old('linea', $preLinea->nombre) }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('linea')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Póliza</label>
                            <input type="text" name="poliza" value="{{ old('poliza', optional($preOrdenSeleccionada)->poliza_seguro ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('poliza')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Referencia</label>
                        <input type="text" name="referencia" value="{{ old('referencia') }}" placeholder="Ej. LF / Angie" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                        @error('referencia')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 border-t border-gray-200 pt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Elaboró</label>
                            <input type="text" value="{{ auth()->user()->name }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 text-gray-700" readonly>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Recibe</label>
                            <input type="text" name="recibe_nombre" value="{{ old('recibe_nombre') }}" placeholder="Nombre completo" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('recibe_nombre')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Celular - Elaboró</label>
                            <input type="text" name="elaboro_celular" value="{{ old('elaboro_celular') }}" placeholder="Opcional" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('elaboro_celular')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Celular - Recibe</label>
                            <input type="text" name="recibe_celular" value="{{ old('recibe_celular') }}" placeholder="Opcional" class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500">
                            @error('recibe_celular')<p class="text-sm text-red-600 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex justify-end space-x-3 pt-6 border-t border-gray-200">
                <a href="{{ route('ordenes-carga.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
                    Cancelar
                </a>
                <button type="submit"
                        @disabled(!$preOrdenSeleccionada)
                        class="inline-flex items-center px-6 py-3 rounded-xl font-semibold shadow-lg transition-all duration-200 transform {{ $preOrdenSeleccionada ? 'bg-gradient-to-r from-green-500 to-emerald-600 text-white hover:from-green-600 hover:to-emerald-700 hover:shadow-xl hover:scale-105' : 'bg-gray-300 text-gray-500 cursor-not-allowed' }}">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Guardar Orden
                </button>
            </div>
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


