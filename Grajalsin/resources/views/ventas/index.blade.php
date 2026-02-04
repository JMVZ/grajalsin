<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">Módulo de Ventas</h2>
                <p class="text-sm text-green-600 mt-1">Pedidos de ventas</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('ventas.pedidos.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    Nuevo Pedido de Venta
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <div class="bg-white overflow-hidden shadow rounded-lg border border-green-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5">
                            <dt class="text-sm font-medium text-gray-500">Clientes</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $totalClientes }}</dd>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 px-5 py-3">
                    <a href="{{ route('clientes.index') }}" class="text-sm text-green-600 font-medium hover:text-green-700">Ver catálogo →</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg border border-green-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5">
                            <dt class="text-sm font-medium text-gray-500">Pedidos del mes</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $pedidosMes }}</dd>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 px-5 py-3">
                    <span class="text-sm text-gray-600">Total: ${{ number_format($totalPedidosMes, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Pedidos Recientes</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha entrega</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($pedidosRecientes as $pedido)
                                <tr>
                                    <td class="px-4 py-2 font-semibold text-green-700">{{ $pedido->folio }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $pedido->cliente->nombre }}</td>
                                    <td class="px-4 py-2 text-sm">
                                        @if($pedido->producto && $pedido->producto->tipo_producto === 'costal')
                                            {{ number_format($pedido->toneladas, 0) }} costales
                                        @else
                                            {{ number_format($pedido->toneladas, 2) }} ton
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 text-sm">{{ $pedido->fecha_entrega->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 text-sm font-medium">${{ number_format($pedido->importe_total, 2) }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($pedido->estatus === 'activa') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($pedido->estatus) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('ventas.pedidos.show', $pedido) }}" class="text-green-600 hover:text-green-800 text-sm">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay pedidos de venta</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($pedidosRecientes->isNotEmpty())
                    <div class="mt-4">
                        <a href="{{ route('ventas.pedidos.index') }}" class="text-sm text-green-600 font-medium hover:text-green-700">Ver todos los pedidos →</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
