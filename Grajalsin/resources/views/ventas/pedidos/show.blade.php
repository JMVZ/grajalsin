<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pedido de Venta {{ $pedidoVenta->folio }}</h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $pedidoVenta->cliente->nombre }} · 
                    @if($pedidoVenta->producto && $pedidoVenta->producto->tipo_producto === 'costal')
                        {{ number_format($pedidoVenta->toneladas, 0) }} costales
                    @else
                        {{ number_format($pedidoVenta->toneladas, 2) }} ton
                    @endif
                </p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('ventas.pedidos.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">← Pedidos</a>
                <a href="{{ route('ventas.pedidos.print', $pedidoVenta) }}" target="_blank" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">Imprimir</a>
                @if($pedidoVenta->estatus === 'activa')
                    <a href="{{ route('ventas.pedidos.edit', $pedidoVenta) }}" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">Editar</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Folio</p>
                    <p class="font-semibold text-green-700">{{ $pedidoVenta->folio }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Fecha</p>
                    <p>{{ $pedidoVenta->fecha->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Cliente</p>
                    <p>{{ $pedidoVenta->cliente->nombre }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">
                        @if($pedidoVenta->producto && $pedidoVenta->producto->tipo_producto === 'costal')
                            Cantidad de costales
                        @else
                            Toneladas
                        @endif
                    </p>
                    <p>
                        @if($pedidoVenta->producto && $pedidoVenta->producto->tipo_producto === 'costal')
                            {{ number_format($pedidoVenta->toneladas, 0) }}
                        @else
                            {{ number_format($pedidoVenta->toneladas, 2) }}
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Precio de venta</p>
                    <p>${{ number_format($pedidoVenta->precio_venta, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Tarifa de flete</p>
                    <p>${{ number_format($pedidoVenta->tarifa_flete, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Bodega de carga</p>
                    <p>{{ $pedidoVenta->bodega->nombre }}{{ $pedidoVenta->bodega->ubicacion ? ' - ' . $pedidoVenta->bodega->ubicacion : '' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Destino</p>
                    <p>{{ $pedidoVenta->destino->nombre }}{{ $pedidoVenta->destino->estado ? ' - ' . $pedidoVenta->destino->estado : '' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Tipo de costal</p>
                    <p>{{ $pedidoVenta->producto?->nombre ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Fecha de entrega</p>
                    <p>{{ $pedidoVenta->fecha_entrega->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Subtotal</p>
                    <p class="font-medium">${{ number_format($pedidoVenta->importe_subtotal, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Total</p>
                    <p class="font-semibold text-green-700">${{ number_format($pedidoVenta->importe_total, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Estatus</p>
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($pedidoVenta->estatus === 'activa') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($pedidoVenta->estatus) }}
                    </span>
                </div>
            </div>
        </div>

        @if($pedidoVenta->notas)
        <div class="bg-white shadow-sm rounded-lg p-6">
            <p class="text-xs font-medium text-gray-500 uppercase mb-1">Notas</p>
            <p class="text-sm text-gray-600">{{ $pedidoVenta->notas }}</p>
        </div>
        @endif

        @if($pedidoVenta->estatus === 'activa')
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="font-medium text-gray-800 mb-3">Acciones</h4>
            <form method="POST" action="{{ route('ventas.pedidos.estatus', $pedidoVenta) }}" id="form-cancelar-pedido" class="flex gap-2">
                @csrf
                <input type="hidden" name="estatus" value="cancelada">
                <button type="button" id="btn-cancelar-pedido" class="px-3 py-1.5 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">Cancelar Pedido</button>
            </form>
        </div>
        @endif
    </div>

    @if($pedidoVenta->estatus === 'activa')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnCancelar = document.getElementById('btn-cancelar-pedido');
            const formCancelar = document.getElementById('form-cancelar-pedido');

            if (btnCancelar && formCancelar) {
                btnCancelar.addEventListener('click', function(e) {
                    e.preventDefault();
                    Swal.fire({
                        title: '¿Cancelar este pedido?',
                        html: '<strong>Esta acción no se puede deshacer.</strong>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Sí, cancelar pedido',
                        cancelButtonText: 'No, mantener activo',
                        reverseButtons: true
                    }).then((result) => {
                        if (result.isConfirmed) {
                            formCancelar.submit();
                        }
                    });
                });
            }
        });
    </script>
    @endif
</x-app-layout>
