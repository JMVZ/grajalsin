@csrf

<div class="space-y-6">
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Información General</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @if(!isset($ordenCompra))
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="insumos" {{ old('tipo', 'insumos') === 'insumos' ? 'selected' : '' }}>Insumos</option>
                    <option value="granos" {{ old('tipo') === 'granos' ? 'selected' : '' }}>Granos</option>
                </select>
                @error('tipo')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            @endif
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha</label>
                <input type="date" name="fecha" value="{{ old('fecha', optional($ordenCompra)->fecha?->format('Y-m-d') ?? date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                @error('fecha')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                <select name="proveedor_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione proveedor</option>
                    @foreach($proveedores as $p)
                        <option value="{{ $p->id }}" {{ old('proveedor_id', optional($ordenCompra)->proveedor_id ?? null) == $p->id ? 'selected' : '' }}>{{ $p->nombre }}</option>
                    @endforeach
                </select>
                @error('proveedor_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Forma de Pago</label>
                <input type="text" name="forma_pago" value="{{ old('forma_pago', optional($ordenCompra)->forma_pago ?? '') }}" placeholder="Ej: Transferencia PPD, 30 días" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('forma_pago')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de compra</label>
                <select name="tipo_compra" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="contado" {{ old('tipo_compra', optional($ordenCompra)->tipo_compra ?? 'contado') === 'contado' ? 'selected' : '' }}>Contado (no carga a estado de cuenta)</option>
                    <option value="credito" {{ old('tipo_compra', optional($ordenCompra)->tipo_compra ?? 'contado') === 'credito' ? 'selected' : '' }}>Crédito (sí carga a cuentas por pagar)</option>
                </select>
                @error('tipo_compra')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Uso CFDI</label>
                <select name="uso_cfdi" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">Seleccione uso CFDI</option>
                    @foreach(config('cfdi.usos_cfdi', []) as $clave => $descripcion)
                        <option value="{{ $clave }}" {{ old('uso_cfdi', optional($ordenCompra)->uso_cfdi ?? '') == $clave ? 'selected' : '' }}>
                            {{ $clave }} - {{ $descripcion }}
                        </option>
                    @endforeach
                </select>
                @error('uso_cfdi')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Elaborado por</label>
                <input type="text" name="elaborado_por" value="{{ old('elaborado_por', optional($ordenCompra)->elaborado_por ?? auth()->user()->name ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('elaborado_por')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Solicitado por</label>
                <input type="text" name="solicitado_por" value="{{ old('solicitado_por', optional($ordenCompra)->solicitado_por ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                @error('solicitado_por')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-gray-800">Artículos</h3>
            <button type="button" id="btn-add-linea" class="px-3 py-1.5 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">+ Agregar línea</button>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Producto</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                        <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                        <th class="px-3 py-2 w-10"></th>
                    </tr>
                </thead>
                <tbody id="lineas-container">
                    @php
                        $lineasDefault = isset($ordenCompra) && $ordenCompra ? $ordenCompra->lineas : collect([(object)['descripcion' => '', 'cantidad' => 1, 'unidad' => 'pza', 'piezas' => null, 'precio_unitario' => 0, 'importe' => 0, 'producto_id' => null]]);
                        $lineasOld = old('lineas', $lineasDefault);
                        if ($lineasOld instanceof \Illuminate\Support\Collection && $lineasOld->isEmpty()) {
                            $lineasOld = [(object)['descripcion' => '', 'cantidad' => 1, 'unidad' => 'pza', 'piezas' => null, 'precio_unitario' => 0, 'importe' => 0, 'producto_id' => null]];
                        }
                        $lineasOld = is_array($lineasOld) ? $lineasOld : $lineasOld->toArray();
                    @endphp
                    @foreach($lineasOld as $i => $linea)
                    <tr class="linea-row border-b border-gray-200">
                        <td class="px-3 py-2">
                            <select name="lineas[{{ $i }}][producto_id]" class="linea-producto block w-40 rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500" data-tipo-producto>
                                <option value="">— Seleccione producto</option>
                                @foreach($productos ?? [] as $prod)
                                    <option value="{{ $prod->id }}" 
                                        data-nombre="{{ e($prod->nombre) }}" 
                                        data-descripcion="{{ e($prod->descripcion ?? $prod->nombre) }}" 
                                        data-unidad="{{ $prod->unidad_medida ?? 'pza' }}"
                                        data-tipo="{{ $prod->tipo_producto ?? 'grano' }}"
                                        {{ data_get($linea, 'producto_id') == $prod->id ? 'selected' : '' }}>
                                        {{ $prod->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <input type="hidden" name="lineas[{{ $i }}][unidad]" class="linea-unidad" value="{{ data_get($linea, 'unidad', 'pza') }}">
                        </td>
                        <td class="px-3 py-2">
                            <div class="flex items-center gap-1">
                                <input type="number" step="0.01" min="0.01" name="lineas[{{ $i }}][cantidad]" value="{{ data_get($linea, 'cantidad', 1) }}" class="linea-cantidad block w-24 rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500" required>
                                <span class="linea-unidad-texto text-xs text-gray-600 whitespace-nowrap">{{ data_get($linea, 'unidad', 'pza') }}</span>
                            </div>
                        </td>
                        <td class="px-3 py-2">
                            <input type="text" name="lineas[{{ $i }}][descripcion]" value="{{ data_get($linea, 'descripcion', '') }}" placeholder="Se llena al elegir producto" class="linea-descripcion block w-full min-w-[180px] rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500" required>
                        </td>
                        <td class="px-3 py-2">
                            <button type="button" class="btn-remove-linea text-red-600 hover:text-red-800 text-sm">✕</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
        <textarea name="notas" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notas', optional($ordenCompra)->notas ?? '') }}</textarea>
        @error('notas')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    @if(!isset($ordenCompra))
    <div id="info-inventario" class="bg-blue-50 border border-blue-200 p-4 rounded-lg">
        <p class="text-sm font-medium text-gray-700">
            <span id="info-texto">
                ℹ️ Las órdenes (insumos y granos) afectarán automáticamente el inventario al guardar.
            </span>
        </p>
    </div>
    @endif

    <div class="flex justify-end space-x-2">
        <a href="{{ isset($ordenCompra) ? route('compras.ordenes.show', $ordenCompra) : route('compras.ordenes.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
        <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Guardar</button>
    </div>
</div>

<template id="linea-template">
    <tr class="linea-row border-b border-gray-200">
        <td class="px-3 py-2">
            <select name="lineas[__INDEX__][producto_id]" class="linea-producto block w-40 rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500" data-tipo-producto>
                <option value="">— Seleccione producto</option>
                @foreach($productos ?? [] as $prod)
                    <option value="{{ $prod->id }}" 
                        data-nombre="{{ e($prod->nombre) }}" 
                        data-descripcion="{{ e($prod->descripcion ?? $prod->nombre) }}" 
                        data-unidad="{{ $prod->unidad_medida ?? 'pza' }}"
                        data-tipo="{{ $prod->tipo_producto ?? 'grano' }}">
                        {{ $prod->nombre }}
                    </option>
                @endforeach
            </select>
            <input type="hidden" name="lineas[__INDEX__][unidad]" class="linea-unidad" value="pza">
        </td>
        <td class="px-3 py-2">
            <div class="flex items-center gap-1">
                <input type="number" step="0.01" min="0.01" name="lineas[__INDEX__][cantidad]" value="1" class="linea-cantidad block w-24 rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500" required>
                <span class="linea-unidad-texto text-xs text-gray-600 whitespace-nowrap">pza</span>
            </div>
        </td>
        <td class="px-3 py-2">
            <input type="text" name="lineas[__INDEX__][descripcion]" value="" placeholder="Se llena al elegir producto" class="linea-descripcion block w-full min-w-[180px] rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500" required>
        </td>
        <td class="px-3 py-2">
            <button type="button" class="btn-remove-linea text-red-600 hover:text-red-800 text-sm">✕</button>
        </td>
    </tr>
</template>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM cargado, iniciando script de orden de compra');
    let lineaIndex = document.querySelectorAll('.linea-row').length;
    const container = document.getElementById('lineas-container');
    const template = document.getElementById('linea-template').innerHTML;
    

    document.getElementById('btn-add-linea').addEventListener('click', function() {
        const html = template.replace(/__INDEX__/g, lineaIndex);
        container.insertAdjacentHTML('beforeend', html);
        lineaIndex++;
        bindLineaEvents();
        // Filtrar productos en la nueva línea
        filtrarProductosPorTipo();
    });

    function bindLineaEvents() {
        container.querySelectorAll('.linea-row').forEach(row => {
            const selProducto = row.querySelector('.linea-producto');
            if (selProducto) {
                selProducto.removeEventListener('change', onProductoChange);
                selProducto.addEventListener('change', onProductoChange);
            }
            const btnRemove = row.querySelector('.btn-remove-linea');
            if (btnRemove) {
                btnRemove.onclick = function() {
                    if (container.querySelectorAll('.linea-row').length > 1) row.remove();
                };
            }
        });
        // Filtrar productos después de agregar nueva línea o al inicializar
        setTimeout(() => {
            const tipoSelect = document.querySelector('select[name="tipo"]');
            if (tipoSelect && tipoSelect.value) {
                filtrarProductosPorTipo();
            }
        }, 100);
    }

    function onProductoChange(e) {
        const row = e.target.closest('.linea-row');
        const opt = e.target.options[e.target.selectedIndex];
        if (!opt || !opt.value) {
            // Limpiar si no hay producto seleccionado
            row.querySelector('.linea-descripcion').value = '';
            row.querySelector('.linea-unidad-texto').textContent = 'pza';
            const hiddenUnidad = row.querySelector('.linea-unidad');
            if (hiddenUnidad) hiddenUnidad.value = 'pza';
            return;
        }
        const desc = opt.dataset.descripcion || opt.dataset.nombre || '';
        const unidad = opt.dataset.unidad || 'pza';
        row.querySelector('.linea-descripcion').value = desc;
        row.querySelector('.linea-unidad-texto').textContent = unidad;
        const hiddenUnidad = row.querySelector('.linea-unidad');
        if (hiddenUnidad) hiddenUnidad.value = unidad;
    }

    // Filtrar productos según tipo de orden
    function filtrarProductosPorTipo() {
        const tipoSelect = document.querySelector('select[name="tipo"]');
        if (!tipoSelect || !tipoSelect.value) {
            return;
        }
        
        const tipoOrden = tipoSelect.value;
        const tipoProductoEsperado = tipoOrden === 'insumos' ? 'costal' : 'grano';
        
        document.querySelectorAll('.linea-producto').forEach(select => {
            const valorSeleccionado = select.value;
            const opcionSeleccionada = select.options[select.selectedIndex];
            const tipoProductoSeleccionado = opcionSeleccionada ? (opcionSeleccionada.dataset.tipo || 'grano') : null;
            
            // Si el producto seleccionado no coincide con el tipo esperado, limpiar selección
            if (valorSeleccionado && tipoProductoSeleccionado !== tipoProductoEsperado) {
                select.value = '';
                const row = select.closest('.linea-row');
                if (row) {
                    const descInput = row.querySelector('.linea-descripcion');
                    const unidadTexto = row.querySelector('.linea-unidad-texto');
                    const hiddenUnidad = row.querySelector('.linea-unidad');
                    if (descInput) descInput.value = '';
                    if (unidadTexto) unidadTexto.textContent = 'pza';
                    if (hiddenUnidad) hiddenUnidad.value = 'pza';
                }
            }
            
            // Ocultar/mostrar opciones según el tipo
            Array.from(select.options).forEach(option => {
                if (option.value === '') {
                    // Mantener visible la opción vacía
                    option.hidden = false;
                    return;
                }
                const tipoProducto = option.dataset.tipo || 'grano';
                // Ocultar productos que no coincidan con el tipo esperado
                option.hidden = tipoProducto !== tipoProductoEsperado;
            });
        });
    }

    // Actualizar mensaje de inventario según tipo (solo en creación)
    function actualizarMensajeInventario() {
        const tipoSelect = document.querySelector('select[name="tipo"]');
        const infoTexto = document.getElementById('info-texto');
        if (tipoSelect && infoTexto) {
            if (tipoSelect.value === 'insumos' || tipoSelect.value === 'granos') {
                infoTexto.innerHTML = 'ℹ️ Las órdenes afectarán automáticamente el inventario al guardar (insumos y granos).';
            }
        }
    }

    // Configurar eventos del tipo de orden
    const tipoSelect = document.querySelector('select[name="tipo"]');
    if (tipoSelect) {
        tipoSelect.addEventListener('change', function() {
            filtrarProductosPorTipo();
            actualizarMensajeInventario();
        });
        // Filtrar y actualizar al cargar la página (con delay para asegurar que el DOM esté listo)
        setTimeout(() => {
            filtrarProductosPorTipo();
            actualizarMensajeInventario();
        }, 300);
    }

    bindLineaEvents();
});
</script>
