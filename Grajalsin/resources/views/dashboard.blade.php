<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Dashboard</h2>
                <p class="text-sm text-gray-600 mt-1 font-medium">Resumen del sistema de control de granos</p>
            </div>
            <div class="flex items-center space-x-2 bg-white px-4 py-2 rounded-lg shadow-sm border border-gray-200">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span class="text-sm font-semibold text-gray-700">{{ $fechaActual->format('d/m/Y H:i') }}</span>
            </div>
        </div>
    </x-slot>

    @php
        $formatoDecimal = fn (float $valor) => number_format($valor, 2, '.', ',');

        $ventasDiferencia = $ventasMes - $ventasMesAnterior;
        $ventasVariacion = $ventasMesAnterior > 0 ? ($ventasDiferencia / $ventasMesAnterior) * 100 : null;

        $comprasDiferencia = $comprasMes - $comprasMesAnterior;
        $comprasVariacion = $comprasMesAnterior > 0 ? ($comprasDiferencia / $comprasMesAnterior) * 100 : null;

        $iconosMovimiento = [
            'entrada' => [
                'color' => 'bg-green-500',
                'svg' => 'M12 6v12m6-6H6',
            ],
            'salida' => [
                'color' => 'bg-red-500',
                'svg' => 'M6 12h12',
            ],
        ];
    @endphp

    <div class="space-y-8">
        <!-- Stats Cards -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Inventario -->
            <div class="bg-gradient-to-br from-white to-gray-50 overflow-hidden shadow-lg rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Total Inventario</p>
                            <p class="text-2xl font-bold text-gray-900 mb-1">
                                {{ $formatoDecimal($totalInventario) }}
                            </p>
                            <p class="text-xs text-gray-400">unidades</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-semibold text-gray-600 uppercase">Valor estimado</span>
                        <span class="text-sm font-bold text-green-700">
                            ${{ $formatoDecimal($valorInventario) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Ventas del Mes -->
            <div class="bg-gradient-to-br from-white to-blue-50 overflow-hidden shadow-lg rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Ventas del Mes</p>
                            <p class="text-2xl font-bold text-gray-900 mb-1">
                                ${{ $formatoDecimal($ventasMes) }}
                            </p>
                            <p class="text-xs text-gray-400">ingresos</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-blue-50 to-cyan-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        @if(!is_null($ventasVariacion))
                            <span class="text-xs font-semibold text-gray-600 uppercase">vs mes anterior</span>
                            <span class="text-sm font-bold {{ $ventasVariacion >= 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ $ventasVariacion >= 0 ? '↑' : '↓' }} {{ $ventasVariacion >= 0 ? '+' : '' }}{{ $formatoDecimal($ventasVariacion) }}%
                            </span>
                        @else
                            <span class="text-xs text-gray-500">Sin datos del mes anterior</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Compras del Mes -->
            <div class="bg-gradient-to-br from-white to-purple-50 overflow-hidden shadow-lg rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Compras del Mes</p>
                            <p class="text-2xl font-bold text-gray-900 mb-1">
                                ${{ $formatoDecimal($comprasMes) }}
                            </p>
                            <p class="text-xs text-gray-400">egresos</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-purple-50 to-indigo-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between">
                        @if(!is_null($comprasVariacion))
                            <span class="text-xs font-semibold text-gray-600 uppercase">vs mes anterior</span>
                            <span class="text-sm font-bold {{ $comprasVariacion <= 0 ? 'text-green-700' : 'text-red-700' }}">
                                {{ $comprasVariacion <= 0 ? '↓' : '↑' }} {{ $comprasVariacion >= 0 ? '+' : '' }}{{ $formatoDecimal($comprasVariacion) }}%
                            </span>
                        @else
                            <span class="text-xs text-gray-500">Sin datos del mes anterior</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Ganancia Neta -->
            <div class="bg-gradient-to-br from-white to-amber-50 overflow-hidden shadow-lg rounded-2xl border border-gray-100 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                <div class="p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-2">Ganancia Neta</p>
                            <p class="text-2xl font-bold text-gray-900 mb-1">
                                ${{ $formatoDecimal($gananciaNeta) }}
                            </p>
                            <p class="text-xs text-gray-400">balance</p>
                        </div>
                        <div class="flex-shrink-0">
                            <div class="w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gradient-to-r from-amber-50 to-orange-50 px-6 py-4 border-t border-gray-100">
                    <div class="flex items-center justify-between text-xs">
                        <span class="font-semibold text-gray-600">Entradas: <span class="text-green-700 font-bold">{{ $formatoDecimal($entradasMesCantidad) }}</span></span>
                        <span class="font-semibold text-gray-600">Salidas: <span class="text-red-700 font-bold">{{ $formatoDecimal($salidasMesCantidad) }}</span></span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Inventario Reciente -->
            <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        Movimientos Recientes
                    </h3>
                </div>
                <div class="px-6 py-5">
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @forelse($movimientosRecientes as $movimiento)
                                @php
                                    $config = $iconosMovimiento[$movimiento->tipo] ?? $iconosMovimiento['entrada'];
                                    $cantidadTexto = ($movimiento->tipo === 'salida' ? '-' : '+') . $formatoDecimal($movimiento->cantidad);
                                    $motivo = str_replace('_', ' ', $movimiento->motivo);
                                @endphp
                                <li>
                                    <div class="relative {{ !$loop->last ? 'pb-8' : '' }}">
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full {{ $config['color'] }} flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['svg'] }}"></path>
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        {{ ucfirst($movimiento->tipo) }} por {{ $motivo }}
                                                        <span class="font-medium text-gray-900">
                                                            — {{ optional($movimiento->producto)->nombre ?? 'Producto eliminado' }}
                                                        </span>
                                                    </p>
                                                    <p class="text-xs text-gray-400">
                                                        {{ optional($movimiento->fecha_movimiento)->diffForHumans() ?? 'Sin fecha' }}
                                                    </p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                    <span class="font-medium {{ $movimiento->tipo === 'salida' ? 'text-red-600' : 'text-green-600' }}">
                                                        {{ $cantidadTexto }} {{ $movimiento->producto->unidad_medida ?? '' }}
                                                    </span>
                                                    @if($movimiento->total || $movimiento->precio_unitario)
                                                        <div class="text-xs text-gray-400">
                                                            ${{ $formatoDecimal($movimiento->total ?? ($movimiento->cantidad * ($movimiento->precio_unitario ?? 0))) }}
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <li>
                                    <div class="text-center py-6 text-gray-500 text-sm">
                                        No hay movimientos registrados aún.
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Tipos de Granos -->
            <div class="bg-white shadow-xl rounded-2xl border border-gray-100 overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-6 py-4">
                    <h3 class="text-lg font-bold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Inventario por Tipo
                    </h3>
                </div>
                <div class="px-6 py-5">
                    @if($inventarioPorProducto->isEmpty())
                        <p class="text-sm text-gray-500">Aún no hay productos con stock registrado.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($inventarioPorProducto as $producto)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-3 h-3 rounded-full mr-3" style="background-color: {{ ['#059669', '#047857', '#10b981', '#34d399', '#6ee7b7', '#a7f3d0'][$loop->index % 6] }}"></div>
                                        <span class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</span>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        {{ $formatoDecimal((float) $producto->stock_actual) }} {{ $producto->unidad_medida }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>