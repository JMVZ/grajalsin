<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">
                    Inventario
                </h2>
                <p class="text-sm text-green-600 mt-1">Control de granos y productos</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('inventario.productos') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Gestionar Productos
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Estadísticas Principales -->
        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
            <!-- Total Productos -->
            <div class="bg-white overflow-hidden shadow rounded-lg border border-green-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Productos</dt>
                                <dd class="text-2xl font-bold text-gray-900">{{ $totalProductos }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 px-5 py-3">
                    <div class="text-sm text-gray-600">
                        <span class="text-green-600 font-medium">{{ $productosConStock }}</span> con stock · 
                        <span class="text-blue-600 font-medium">{{ $productosSinStock }}</span> bajo pedido
                    </div>
                </div>
            </div>

            <!-- Valor Inventario -->
            <div class="bg-white overflow-hidden shadow rounded-lg border border-green-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-emerald-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Valor Inventario</dt>
                                <dd class="text-2xl font-bold text-gray-900">${{ number_format($valorInventario, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-green-50 px-5 py-3">
                    <div class="text-sm text-gray-600">
                        Solo productos con stock
                    </div>
                </div>
            </div>

            <!-- Alertas -->
            <div class="bg-white overflow-hidden shadow rounded-lg border border-green-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 {{ $alertasStockBajo > 0 ? 'bg-red-500' : 'bg-teal-500' }} rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Alertas de Stock</dt>
                                <dd class="text-2xl font-bold text-gray-900">{{ $alertasStockBajo }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="{{ $alertasStockBajo > 0 ? 'bg-red-50' : 'bg-green-50' }} px-5 py-3">
                    <div class="text-sm {{ $alertasStockBajo > 0 ? 'text-red-600' : 'text-green-600' }}">
                        {{ $alertasStockBajo > 0 ? '⚠️ Productos con stock bajo' : '✅ Todo en orden' }}
                    </div>
                </div>
            </div>

            <!-- Pérdidas del Mes -->
            <div class="bg-white overflow-hidden shadow rounded-lg border border-green-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-12 h-12 bg-orange-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">Pérdidas del Mes</dt>
                                <dd class="text-2xl font-bold text-gray-900">${{ number_format($perdidasMes, 2) }}</dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-orange-50 px-5 py-3">
                    <a href="{{ route('inventario.perdidas') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">
                        Ver detalle →
                    </a>
                </div>
            </div>
        </div>

        <!-- Productos y Movimientos Recientes -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Listado de Productos -->
            <div class="bg-white shadow rounded-lg border border-green-200">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Productos en Inventario</h3>
                    
                    <div class="space-y-3">
                        @forelse($productos->take(8) as $producto)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center flex-1">
                                    <div class="flex-shrink-0">
                                        @if($producto->maneja_stock)
                                            @if($producto->estado_stock === 'bajo')
                                                <span class="inline-block w-3 h-3 bg-red-500 rounded-full"></span>
                                            @elseif($producto->estado_stock === 'alto')
                                                <span class="inline-block w-3 h-3 bg-blue-500 rounded-full"></span>
                                            @else
                                                <span class="inline-block w-3 h-3 bg-green-500 rounded-full"></span>
                                            @endif
                                        @else
                                            <span class="inline-block w-3 h-3 bg-gray-400 rounded-full"></span>
                                        @endif
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</p>
                                        <p class="text-xs text-gray-500">
                                            @if($producto->maneja_stock)
                                                {{ number_format($producto->stock_actual, 2) }} {{ $producto->unidad_medida }}
                                            @else
                                                <span class="text-blue-600">Bajo pedido</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                                @if($producto->maneja_stock)
                                    <div class="text-right">
                                        <p class="text-sm font-medium text-gray-900">
                                            ${{ number_format($producto->valor_inventario, 2) }}
                                        </p>
                                    </div>
                                @endif
                            </div>
                        @empty
                            <p class="text-gray-500 text-sm">No hay productos registrados</p>
                        @endforelse
                    </div>
                    
                    @if($productos->count() > 8)
                        <div class="mt-4">
                            <a href="{{ route('inventario.productos') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                                Ver todos los productos →
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Movimientos Recientes -->
            <div class="bg-white shadow rounded-lg border border-green-200">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Movimientos Recientes</h3>
                    
                    <div class="flow-root">
                        <ul class="-mb-8">
                            @forelse($movimientosRecientes as $index => $movimiento)
                                <li>
                                    <div class="relative pb-8">
                                        @if($index < $movimientosRecientes->count() - 1)
                                            <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                        @endif
                                        <div class="relative flex space-x-3">
                                            <div>
                                                <span class="h-8 w-8 rounded-full {{ $movimiento->tipo === 'entrada' ? 'bg-green-500' : 'bg-red-500' }} flex items-center justify-center ring-8 ring-white">
                                                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        @if($movimiento->tipo === 'entrada')
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                        @else
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                        @endif
                                                    </svg>
                                                </span>
                                            </div>
                                            <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                <div>
                                                    <p class="text-sm text-gray-500">
                                                        <span class="font-medium text-gray-900">{{ $movimiento->producto->nombre ?? 'Producto eliminado' }}</span> - 
                                                        {{ $movimiento->motivo }}
                                                    </p>
                                                    <p class="text-xs text-gray-400">{{ $movimiento->fecha_movimiento->diffForHumans() }}</p>
                                                </div>
                                                <div class="text-right text-sm whitespace-nowrap">
                                                    <span class="font-medium {{ $movimiento->tipo === 'entrada' ? 'text-green-600' : 'text-red-600' }}">
                                                        {{ $movimiento->tipo === 'entrada' ? '+' : '-' }}{{ number_format($movimiento->cantidad, 2) }} {{ $movimiento->producto->unidad_medida ?? 'kg' }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @empty
                                <p class="text-gray-500 text-sm">No hay movimientos registrados</p>
                            @endforelse
                        </ul>
                    </div>
                    
                    @if($movimientosRecientes->count() > 0)
                        <div class="mt-4">
                            <a href="{{ route('inventario.movimientos') }}" class="text-sm text-green-600 hover:text-green-700 font-medium">
                                Ver todos los movimientos →
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="bg-white shadow rounded-lg border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <a href="{{ route('inventario.movimientos.create') }}" class="flex items-center p-4 bg-green-50 hover:bg-green-100 rounded-lg transition">
                        <svg class="w-8 h-8 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Nuevo Movimiento</p>
                            <p class="text-xs text-gray-500">Entrada o Salida</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('inventario.perdidas.create') }}" class="flex items-center p-4 bg-orange-50 hover:bg-orange-100 rounded-lg transition">
                        <svg class="w-8 h-8 text-orange-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Registrar Pérdida</p>
                            <p class="text-xs text-gray-500">Control de mermas</p>
                        </div>
                    </a>
                    
                    <a href="{{ route('inventario.reportes') }}" class="flex items-center p-4 bg-blue-50 hover:bg-blue-100 rounded-lg transition">
                        <svg class="w-8 h-8 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Ver Reportes</p>
                            <p class="text-xs text-gray-500">Análisis y estadísticas</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

