@csrf

<div class="space-y-6">
    <!-- Fecha -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Información General</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" value="{{ old('fecha', isset($preOrden) && $preOrden->fecha ? $preOrden->fecha->format('Y-m-d') : date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                @error('fecha')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            @if(isset($preOrden) && $preOrden->folio)
            <div>
                <label class="block text-sm font-medium text-gray-700">Folio</label>
                <input type="text" value="{{ $preOrden->folio }}" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 shadow-sm" disabled>
                <p class="text-xs text-gray-500 mt-1">El folio se genera automáticamente</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Operador / Chofer -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Operador</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Seleccionar Chofer</label>
                <select name="chofer_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione un chofer</option>
                    @foreach($choferes as $chofer)
                        <option value="{{ $chofer->id }}" {{ old('chofer_id', $preOrden->chofer_id ?? '') == $chofer->id ? 'selected' : '' }}>
                            {{ $chofer->nombre }} - {{ $chofer->telefono }}
                        </option>
                    @endforeach
                </select>
                @error('chofer_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <!-- Vehículo -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Vehículo</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Placa del Tractor</label>
                <input type="text" name="placa_tractor" value="{{ old('placa_tractor', $preOrden->placa_tractor ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                @error('placa_tractor')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Placa del Remolque</label>
                <input type="text" name="placa_remolque" value="{{ old('placa_remolque', $preOrden->placa_remolque ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                @error('placa_remolque')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Modelo</label>
                <input type="text" name="modelo" value="{{ old('modelo', $preOrden->modelo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('modelo')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <!-- Línea de Carga -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Línea de Transporte</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Línea de Carga</label>
                <select name="linea_carga_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione una línea</option>
                    @foreach($lineasCarga as $linea)
                        <option value="{{ $linea->id }}" data-base-operacion="{{ $linea->base_operacion }}" {{ old('linea_carga_id', $preOrden->linea_carga_id ?? '') == $linea->id ? 'selected' : '' }}>
                            {{ $linea->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('linea_carga_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Póliza de Seguro</label>
                <input type="text" name="poliza_seguro" value="{{ old('poliza_seguro', $preOrden->poliza_seguro ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('poliza_seguro')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Base de la Línea</label>
                <input type="text" name="base_linea" value="{{ old('base_linea', $preOrden->base_linea ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('base_linea')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <!-- Destino y Cliente -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Destino y Cliente</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Destino</label>
                <select name="destino_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione un destino</option>
                    @foreach($destinos as $destino)
                        <option value="{{ $destino->id }}" {{ old('destino_id', $preOrden->destino_id ?? '') == $destino->id ? 'selected' : '' }}>
                            {{ $destino->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('destino_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Tarifa</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" name="tarifa" value="{{ old('tarifa', $preOrden->tarifa ?? '0.00') }}" step="0.01" min="0" class="block w-full rounded-md border-gray-300 pl-7 focus:border-green-500 focus:ring-green-500" required>
                </div>
                @error('tarifa')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Cliente</label>
                <select name="cliente_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione un cliente</option>
                    @foreach($clientes as $cliente)
                        <option value="{{ $cliente->id }}" {{ old('cliente_id', $preOrden->cliente_id ?? '') == $cliente->id ? 'selected' : '' }}>
                            {{ $cliente->codigo }} - {{ $cliente->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('cliente_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <!-- Productos / Tipo de Grano -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Productos a Cargar</h3>
            <button type="button" onclick="agregarProducto()" class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded-md text-sm">+ Agregar Producto</button>
        </div>
        
        <div id="productos-container" class="space-y-3">
            @if(isset($preOrden) && $preOrden->productos->count() > 0)
                @foreach($preOrden->productos as $index => $producto)
                    <div class="producto-item grid grid-cols-12 gap-2 items-end border-b pb-3">
                        <div class="col-span-3">
                            <label class="block text-sm font-medium text-gray-700">Tipo de Carga</label>
                            <select name="productos[{{ $index }}][tipo_carga]" onchange="toggleTipoCarga(this, {{ $index }})" class="tipo-carga-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                <option value="costal" {{ $producto->pivot->tipo_carga == 'costal' ? 'selected' : '' }}>Costal</option>
                                <option value="granel" {{ $producto->pivot->tipo_carga == 'granel' ? 'selected' : '' }}>Granel</option>
                            </select>
                        </div>
                        <div class="col-span-4">
                            <label class="block text-sm font-medium text-gray-700">Producto</label>
                            <select name="productos[{{ $index }}][producto_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                                <option value="">Seleccione...</option>
                                @foreach($productos as $prod)
                                    <option value="{{ $prod->id }}" {{ $producto->id == $prod->id ? 'selected' : '' }}>{{ $prod->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2 campo-cantidad" style="display: {{ $producto->pivot->tipo_carga == 'costal' ? 'block' : 'none' }};">
                            <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                            <input type="number" name="productos[{{ $index }}][cantidad]" value="{{ $producto->pivot->cantidad }}" step="0.01" min="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" {{ $producto->pivot->tipo_carga == 'costal' ? 'required' : '' }}>
                        </div>
                        <div class="col-span-2 campo-toneladas" style="display: {{ $producto->pivot->tipo_carga == 'granel' ? 'block' : 'none' }};">
                            <label class="block text-sm font-medium text-gray-700">Toneladas</label>
                            <input type="number" name="productos[{{ $index }}][toneladas]" value="{{ $producto->pivot->toneladas }}" step="0.01" min="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" {{ $producto->pivot->tipo_carga == 'granel' ? 'required' : '' }}>
                        </div>
                        <div class="col-span-1">
                            <button type="button" onclick="eliminarProducto(this)" class="w-full bg-red-600 hover:bg-red-700 text-white px-2 py-2 rounded-md text-sm">×</button>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="producto-item grid grid-cols-12 gap-2 items-end border-b pb-3">
                    <div class="col-span-3">
                        <label class="block text-sm font-medium text-gray-700">Tipo de Carga</label>
                        <select name="productos[0][tipo_carga]" onchange="toggleTipoCarga(this, 0)" class="tipo-carga-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            <option value="costal">Costal</option>
                            <option value="granel">Granel</option>
                        </select>
                    </div>
                    <div class="col-span-4">
                        <label class="block text-sm font-medium text-gray-700">Producto</label>
                        <select name="productos[0][producto_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            <option value="">Seleccione...</option>
                            @foreach($productos as $producto)
                                <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-2 campo-cantidad">
                        <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                        <input type="number" name="productos[0][cantidad]" step="0.01" min="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    </div>
                    <div class="col-span-2 campo-toneladas" style="display: none;">
                        <label class="block text-sm font-medium text-gray-700">Toneladas</label>
                        <input type="number" name="productos[0][toneladas]" step="0.01" min="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div class="col-span-1">
                        <button type="button" onclick="eliminarProducto(this)" class="w-full bg-red-600 hover:bg-red-700 text-white px-2 py-2 rounded-md text-sm">×</button>
                    </div>
                </div>
            @endif
        </div>
        @error('productos')<p class="text-sm text-red-600 mt-2">{{ $message }}</p>@enderror
    </div>

    <!-- Información Interna -->
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Información Interna</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Coordinador</label>
                <input type="text" name="coordinador_nombre" value="{{ old('coordinador_nombre', $preOrden->coordinador_nombre ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('coordinador_nombre')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Teléfono Coordinador</label>
                <input type="text" name="coordinador_telefono" value="{{ old('coordinador_telefono', $preOrden->coordinador_telefono ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('coordinador_telefono')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Constancia Situación Fiscal (RFC)</label>
                <input type="text" name="constancia_fiscal" value="{{ old('constancia_fiscal', $preOrden->constancia_fiscal ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('constancia_fiscal')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Precio Factura</label>
                <div class="mt-1 relative rounded-md shadow-sm">
                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                        <span class="text-gray-500 sm:text-sm">$</span>
                    </div>
                    <input type="number" name="precio_factura" value="{{ old('precio_factura', $preOrden->precio_factura ?? '') }}" step="0.01" min="0" class="block w-full rounded-md border-gray-300 pl-7 focus:border-green-500 focus:ring-green-500">
                </div>
                @error('precio_factura')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700">Notas</label>
                <textarea name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notas', $preOrden->notas ?? '') }}</textarea>
                @error('notas')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>
</div>

<div class="mt-8 flex justify-end space-x-3 pt-6 border-t border-gray-200">
    <a href="{{ route('pre-ordenes.index') }}" class="inline-flex items-center px-6 py-3 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
        Cancelar
    </a>
    <button type="submit" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-200 transform hover:scale-105">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
        Guardar
    </button>
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
let productoIndex = {{ isset($preOrden) && $preOrden->productos->count() > 0 ? $preOrden->productos->count() : 1 }};

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

document.addEventListener('DOMContentLoaded', function () {
    const lineaSelect = document.querySelector('select[name="linea_carga_id"]');
    const baseInput = document.querySelector('input[name="base_linea"]');

    if (!lineaSelect || !baseInput) {
        return;
    }

    const updateBaseLinea = () => {
        const option = lineaSelect.options[lineaSelect.selectedIndex];
        const base = option ? option.getAttribute('data-base-operacion') || '' : '';
        baseInput.value = base;
    };

    if (!baseInput.value) {
        updateBaseLinea();
    }

    lineaSelect.addEventListener('change', updateBaseLinea);
});

function toggleTipoCarga(select, index) {
    const item = select.closest('.producto-item');
    const campoCantidad = item.querySelector('.campo-cantidad');
    const campoToneladas = item.querySelector('.campo-toneladas');
    const inputCantidad = item.querySelector('[name*="[cantidad]"]');
    const inputToneladas = item.querySelector('[name*="[toneladas]"]');
    
    if (select.value === 'costal') {
        // Mostrar cantidad, ocultar toneladas
        campoCantidad.style.display = 'block';
        campoToneladas.style.display = 'none';
        inputCantidad.required = true;
        inputToneladas.required = false;
        inputToneladas.value = '';
    } else if (select.value === 'granel') {
        // Mostrar toneladas, ocultar cantidad
        campoCantidad.style.display = 'none';
        campoToneladas.style.display = 'block';
        inputCantidad.required = false;
        inputCantidad.value = '';
        inputToneladas.required = true;
    }
}

function agregarProducto() {
    const container = document.getElementById('productos-container');
    const productosOptions = `@foreach($productos as $producto)<option value="{{ $producto->id }}">{{ $producto->nombre }}</option>@endforeach`;
    
    const nuevoProducto = `
        <div class="producto-item grid grid-cols-12 gap-2 items-end border-b pb-3">
            <div class="col-span-3">
                <label class="block text-sm font-medium text-gray-700">Tipo de Carga</label>
                <select name="productos[${productoIndex}][tipo_carga]" onchange="toggleTipoCarga(this, ${productoIndex})" class="tipo-carga-select mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="costal">Costal</option>
                    <option value="granel">Granel</option>
                </select>
            </div>
            <div class="col-span-4">
                <label class="block text-sm font-medium text-gray-700">Producto</label>
                <select name="productos[${productoIndex}][producto_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione...</option>
                    ${productosOptions}
                </select>
            </div>
            <div class="col-span-2 campo-cantidad">
                <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" name="productos[${productoIndex}][cantidad]" step="0.01" min="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
            </div>
            <div class="col-span-2 campo-toneladas" style="display: none;">
                <label class="block text-sm font-medium text-gray-700">Toneladas</label>
                <input type="number" name="productos[${productoIndex}][toneladas]" step="0.01" min="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
            </div>
            <div class="col-span-1">
                <button type="button" onclick="eliminarProducto(this)" class="w-full bg-red-600 hover:bg-red-700 text-white px-2 py-2 rounded-md text-sm">×</button>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', nuevoProducto);
    productoIndex++;
}

function eliminarProducto(button) {
    const container = document.getElementById('productos-container');
    const items = container.querySelectorAll('.producto-item');
    
    // No permitir eliminar si solo hay un producto
    if (items.length > 1) {
        button.closest('.producto-item').remove();
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Atención',
            text: 'Debe haber al menos un producto en la pre-orden',
            confirmButtonColor: '#16a34a'
        });
    }
}
</script>

