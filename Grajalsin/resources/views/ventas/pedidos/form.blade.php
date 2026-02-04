@csrf

<div class="space-y-6">
    <div class="bg-gray-50 p-4 rounded-lg">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">PEDIDOS (VENTAS)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Nombre del cliente</label>
                <select name="cliente_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione cliente</option>
                    @foreach($clientes ?? [] as $c)
                        <option value="{{ $c->id }}" {{ old('cliente_id', optional($pedidoVenta)->cliente_id ?? null) == $c->id ? 'selected' : '' }}>{{ $c->nombre }}</option>
                    @endforeach
                </select>
                @error('cliente_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label id="label-cantidad" class="block text-sm font-medium text-gray-700">Toneladas</label>
                <input type="number" step="0.01" min="0.01" name="toneladas" id="input-toneladas" value="{{ old('toneladas', optional($pedidoVenta)->toneladas ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required placeholder="0.00">
                @error('toneladas')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Precio de venta</label>
                <input type="number" step="0.01" min="0" name="precio_venta" value="{{ old('precio_venta', optional($pedidoVenta)->precio_venta ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required placeholder="0.00">
                @error('precio_venta')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tarifa de flete</label>
                <input type="number" step="0.01" min="0" name="tarifa_flete" value="{{ old('tarifa_flete', optional($pedidoVenta)->tarifa_flete ?? 0) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="0.00">
                @error('tarifa_flete')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Bodega de carga</label>
                <select name="bodega_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione bodega</option>
                    @foreach($bodegas ?? [] as $b)
                        <option value="{{ $b->id }}" {{ old('bodega_id', optional($pedidoVenta)->bodega_id ?? null) == $b->id ? 'selected' : '' }}>{{ $b->nombre }}{{ $b->ubicacion ? ' - ' . $b->ubicacion : '' }}</option>
                    @endforeach
                </select>
                @error('bodega_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Destino</label>
                <select name="destino_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                    <option value="">Seleccione destino</option>
                    @foreach($destinos ?? [] as $d)
                        <option value="{{ $d->id }}" {{ old('destino_id', optional($pedidoVenta)->destino_id ?? null) == $d->id ? 'selected' : '' }}>{{ $d->nombre }}{{ $d->estado ? ' - ' . $d->estado : '' }}</option>
                    @endforeach
                </select>
                @error('destino_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Tipo de costal</label>
                <select name="producto_id" id="select-producto" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">— Sin especificar</option>
                    @foreach($productos ?? [] as $p)
                        <option value="{{ $p->id }}" 
                            data-tipo="{{ $p->tipo_producto ?? 'grano' }}"
                            {{ old('producto_id', optional($pedidoVenta)->producto_id ?? null) == $p->id ? 'selected' : '' }}>{{ $p->nombre }}</option>
                    @endforeach
                </select>
                @error('producto_id')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha de entrega</label>
                <input type="date" name="fecha_entrega" value="{{ old('fecha_entrega', optional($pedidoVenta)->fecha_entrega?->format('Y-m-d') ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                @error('fecha_entrega')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700">Fecha del pedido</label>
                <input type="date" name="fecha" value="{{ old('fecha', optional($pedidoVenta)->fecha?->format('Y-m-d') ?? date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                @error('fecha')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded-lg">
        <label class="block text-sm font-medium text-gray-700 mb-2">Notas</label>
        <textarea name="notas" rows="2" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notas', optional($pedidoVenta)->notas ?? '') }}</textarea>
        @error('notas')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex justify-end space-x-2">
        <a href="{{ isset($pedidoVenta) ? route('ventas.pedidos.show', $pedidoVenta) : route('ventas.pedidos.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
        <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Guardar</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const selectProducto = document.getElementById('select-producto');
    const labelCantidad = document.getElementById('label-cantidad');
    const inputToneladas = document.getElementById('input-toneladas');

    function actualizarLabel() {
        if (!selectProducto || !labelCantidad) return;
        
        const selectedOption = selectProducto.options[selectProducto.selectedIndex];
        const tipoProducto = selectedOption && selectedOption.value ? (selectedOption.dataset.tipo || 'grano') : 'grano';
        
        if (tipoProducto === 'costal') {
            labelCantidad.textContent = 'Cantidad de costales';
            inputToneladas.setAttribute('step', '1');
            inputToneladas.setAttribute('min', '1');
            inputToneladas.setAttribute('placeholder', '0');
        } else {
            labelCantidad.textContent = 'Toneladas';
            inputToneladas.setAttribute('step', '0.01');
            inputToneladas.setAttribute('min', '0.01');
            inputToneladas.setAttribute('placeholder', '0.00');
        }
    }

    // Actualizar al cargar la página
    actualizarLabel();

    // Actualizar cuando cambia la selección
    if (selectProducto) {
        selectProducto.addEventListener('change', actualizarLabel);
    }
});
</script>
