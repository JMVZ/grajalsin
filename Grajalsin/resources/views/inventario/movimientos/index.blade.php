<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">
                    Movimientos de Inventario
                </h2>
                <p class="text-sm text-green-600 mt-1">Historial de entradas y salidas</p>
            </div>
            <a href="{{ route('inventario.movimientos.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Movimiento
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Lista de Movimientos -->
        <div class="bg-white shadow rounded-lg border border-green-200">
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo</th>
                                    <th class="hidden md:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Motivo</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th class="hidden sm:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                    <th class="hidden lg:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                </tr>
                            </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($movimientos as $movimiento)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-900">
                                        <div class="text-xs sm:text-sm">{{ $movimiento->fecha_movimiento->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500 sm:hidden">{{ $movimiento->fecha_movimiento->format('H:i') }}</div>
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $movimiento->producto->nombre }}</div>
                                        @if($movimiento->referencia)
                                            <div class="text-xs text-gray-500">Ref: {{ $movimiento->referencia }}</div>
                                        @endif
                                        <div class="md:hidden mt-1">
                                            <span class="text-xs text-gray-500">{{ ucfirst(str_replace('_', ' ', $movimiento->motivo)) }}</span>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4">
                                        @if($movimiento->tipo === 'entrada')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                ↗️ Entrada
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                ↘️ Salida
                                            </span>
                                        @endif
                                    </td>
                                    <td class="hidden md:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-500">
                                        {{ ucfirst(str_replace('_', ' ', $movimiento->motivo)) }}
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4 text-sm font-medium {{ $movimiento->tipo === 'entrada' ? 'text-green-600' : 'text-red-600' }}">
                                        <div>{{ $movimiento->tipo === 'entrada' ? '+' : '-' }}{{ number_format($movimiento->cantidad, 2) }}</div>
                                        <div class="text-xs text-gray-500">{{ $movimiento->producto->unidad_medida }}</div>
                                        @if($movimiento->total)
                                            <div class="sm:hidden text-xs text-gray-600 mt-1">${{ number_format($movimiento->total, 2) }}</div>
                                        @endif
                                    </td>
                                    <td class="hidden sm:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-900">
                                        @if($movimiento->total)
                                            ${{ number_format($movimiento->total, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="hidden lg:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-500">
                                        {{ $movimiento->usuario->name }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No hay movimientos registrados. 
                                        <a href="{{ route('inventario.movimientos.create') }}" class="text-green-600 hover:text-green-700 font-medium">Registrar el primero</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="mt-4">
                    {{ $movimientos->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

