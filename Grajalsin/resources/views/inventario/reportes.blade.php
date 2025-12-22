<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">
                    Reportes de Inventario
                </h2>
                <p class="text-sm text-green-600 mt-1">Análisis y estadísticas</p>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Movimientos del Mes -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white shadow rounded-lg border border-green-200">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Movimientos del Mes</h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-4 bg-green-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Total Entradas</p>
                                    <p class="text-xs text-gray-500">Productos que ingresaron</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-green-600">{{ number_format($entradasMes, 2) }}</p>
                                <p class="text-xs text-gray-500">unidades</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-red-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Total Salidas</p>
                                    <p class="text-xs text-gray-500">Productos que salieron</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-red-600">{{ number_format($salidasMes, 2) }}</p>
                                <p class="text-xs text-gray-500">unidades</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between p-4 bg-blue-50 rounded-lg">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <p class="text-sm font-medium text-gray-900">Balance</p>
                                    <p class="text-xs text-gray-500">Diferencia neta</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-2xl font-bold text-blue-600">{{ number_format($entradasMes - $salidasMes, 2) }}</p>
                                <p class="text-xs text-gray-500">unidades</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pérdidas por Tipo -->
            <div class="bg-white shadow rounded-lg border border-green-200">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Pérdidas por Tipo</h3>
                    
                    @if($perdidasPorTipo->count() > 0)
                        <div class="space-y-3">
                            @foreach($perdidasPorTipo as $perdida)
                                @php
                                    $porcentaje = ($perdida->total / $perdidasPorTipo->sum('total')) * 100;
                                @endphp
                                <div>
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-sm font-medium text-gray-700">
                                            {{ ucfirst(str_replace('_', ' ', $perdida->tipo_perdida)) }}
                                        </span>
                                        <span class="text-sm text-gray-500">
                                            {{ $perdida->total }} casos - ${{ number_format($perdida->valor_total, 2) }}
                                        </span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-orange-500 h-2 rounded-full" style="width: {{ $porcentaje }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-sm text-center py-8">No hay pérdidas registradas</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Productos con Más Pérdidas -->
        <div class="bg-white shadow rounded-lg border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Top 10 Productos con Más Pérdidas</h3>
                
                @if($productosMasPerdidas->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad Perdida</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor Total</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($productosMasPerdidas as $index => $item)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $item->producto->nombre }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-red-600">
                                            {{ number_format($item->total_perdido, 2) }} {{ $item->producto->unidad_medida }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            ${{ number_format($item->valor_total ?? 0, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 text-sm text-center py-8">No hay datos de pérdidas</p>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>

