<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">Módulo de Compras</h2>
                <p class="text-sm text-green-600 mt-1">Órdenes de compra (insumos y granos)</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('compras.ordenes.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition">
                    Nueva Orden de Compra
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5">
                            <dt class="text-sm font-medium text-gray-500">Proveedores</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $totalProveedores }}</dd>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 px-5 py-3">
                    <a href="{{ route('proveedores.index') }}" class="text-sm text-green-600 font-medium hover:text-green-700">Ver catálogo →</a>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow rounded-lg border border-green-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5">
                            <dt class="text-sm font-medium text-gray-500">Órdenes del mes</dt>
                            <dd class="text-2xl font-bold text-gray-900">{{ $ordenesMes }}</dd>
                        </div>
                    </div>
                </div>
                <div class="bg-purple-50 px-5 py-3">
                    <span class="text-sm text-gray-600">Total: ${{ number_format($totalOrdenesMes, 2) }}</span>
                </div>
            </div>
        </div>

        <div class="bg-white shadow rounded-lg border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Órdenes Recientes</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Proveedor</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($ordenesRecientes as $orden)
                                <tr>
                                    <td class="px-4 py-2 font-semibold text-green-700">{{ $orden->folio }}</td>
                                    <td class="px-4 py-2 text-sm">{{ ucfirst($orden->tipo) }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $orden->proveedor->nombre }}</td>
                                    <td class="px-4 py-2 text-sm">{{ $orden->fecha->format('d/m/Y') }}</td>
                                    <td class="px-4 py-2 text-sm font-medium">${{ number_format($orden->total, 2) }}</td>
                                    <td class="px-4 py-2">
                                        <span class="px-2 py-1 text-xs rounded-full
                                            @if($orden->estatus === 'activa') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($orden->estatus) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-2">
                                        <a href="{{ route('compras.ordenes.show', $orden) }}" class="text-green-600 hover:text-green-800 text-sm">Ver</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay órdenes de compra</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if($ordenesRecientes->isNotEmpty())
                    <div class="mt-4">
                        <a href="{{ route('compras.ordenes.index') }}" class="text-sm text-green-600 font-medium hover:text-green-700">Ver todas las órdenes →</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
