<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Orden de Compra {{ $ordenCompra->folio }}</h2>
                <p class="text-sm text-gray-500 mt-1">{{ ucfirst($ordenCompra->tipo) }} · {{ $ordenCompra->proveedor->nombre }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('compras.ordenes.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">← Órdenes</a>
                <a href="{{ route('compras.ordenes.print', $ordenCompra) }}" target="_blank" class="px-4 py-2 bg-gray-600 text-white rounded-md text-sm hover:bg-gray-700">Imprimir</a>
                @if($ordenCompra->estatus === 'activa')
                    <a href="{{ route('compras.ordenes.edit', $ordenCompra) }}" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">Editar</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Folio</p>
                    <p class="font-semibold text-green-700">{{ $ordenCompra->folio }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Fecha</p>
                    <p>{{ $ordenCompra->fecha->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Proveedor</p>
                    <p>{{ $ordenCompra->proveedor->nombre }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Forma de Pago</p>
                    <p>{{ $ordenCompra->forma_pago ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Tipo de compra</p>
                    <p>{{ ($ordenCompra->tipo_compra ?? 'contado') === 'credito' ? 'Crédito (carga a cuentas por pagar)' : 'Contado' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Uso CFDI</p>
                    <p>@php
                        $uso = $ordenCompra->uso_cfdi;
                        $desc = $uso ? (config('cfdi.usos_cfdi')[$uso] ?? null) : null;
                    @endphp
                    {{ $uso ? ($desc ? "{$uso} - {$desc}" : $uso) : '—' }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium text-gray-500 uppercase">Estatus</p>
                    <span class="px-2 py-1 text-xs rounded-full
                        @if($ordenCompra->estatus === 'activa') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($ordenCompra->estatus) }}
                    </span>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <h3 class="px-6 py-4 font-semibold text-gray-800 border-b border-gray-200">Artículos</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($ordenCompra->lineas as $linea)
                        <tr>
                            <td class="px-4 py-2">{{ number_format($linea->cantidad, 2) }} {{ $linea->unidad ?? '' }}</td>
                            <td class="px-4 py-2">{{ $linea->descripcion }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($ordenCompra->elaborado_por || $ordenCompra->solicitado_por || $ordenCompra->notas)
        <div class="bg-white shadow-sm rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($ordenCompra->elaborado_por)
                <p><span class="text-gray-500">Elaboró:</span> {{ $ordenCompra->elaborado_por }}</p>
                @endif
                @if($ordenCompra->solicitado_por)
                <p><span class="text-gray-500">Solicita:</span> {{ $ordenCompra->solicitado_por }}</p>
                @endif
            </div>
            @if($ordenCompra->notas)
            <p class="mt-4 text-sm text-gray-600">{{ $ordenCompra->notas }}</p>
            @endif
        </div>
        @endif

        @if($ordenCompra->estatus === 'activa')
        <div class="bg-white shadow-sm rounded-lg p-6">
            <h4 class="font-medium text-gray-800 mb-3">Acciones</h4>
            <form method="POST" action="{{ route('compras.ordenes.estatus', $ordenCompra) }}" id="form-cancelar-orden" class="flex gap-2">
                @csrf
                <input type="hidden" name="estatus" value="cancelada">
                <button type="button" id="btn-cancelar-orden" class="px-3 py-1.5 bg-red-600 text-white rounded-md text-sm hover:bg-red-700">Cancelar Orden</button>
            </form>
        </div>
        @endif
    </div>

    @if($ordenCompra->estatus === 'activa')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const btnCancelar = document.getElementById('btn-cancelar-orden');
            const formCancelar = document.getElementById('form-cancelar-orden');
            
            if (btnCancelar && formCancelar) {
                btnCancelar.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    Swal.fire({
                        title: '¿Cancelar esta orden?',
                        html: 'Esto revertirá las entradas de inventario si aplica.<br><strong>Esta acción no se puede deshacer.</strong>',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc2626',
                        cancelButtonColor: '#6b7280',
                        confirmButtonText: 'Sí, cancelar orden',
                        cancelButtonText: 'No, mantener activa',
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
