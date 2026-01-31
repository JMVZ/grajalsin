<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">
                    Control de Pérdidas
                </h2>
                <p class="text-sm text-green-600 mt-1">Registro de mermas y pérdidas</p>
            </div>
            <a href="{{ route('inventario.perdidas.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                Registrar Pérdida
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Lista de Pérdidas -->
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
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                                    <th class="hidden sm:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Valor</th>
                                    <th class="hidden md:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                    <th class="hidden lg:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($perdidas as $perdida)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-900">
                                        <div class="text-xs sm:text-sm">{{ $perdida->fecha_deteccion->format('d/m/Y') }}</div>
                                        <div class="text-xs text-gray-500 sm:hidden">{{ $perdida->fecha_deteccion->format('H:i') }}</div>
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $perdida->producto->nombre }}</div>
                                        @if($perdida->valor_estimado)
                                            <div class="sm:hidden text-xs text-gray-600 mt-1">${{ number_format($perdida->valor_estimado, 2) }}</div>
                                        @endif
                                        <div class="md:hidden sm:block text-xs text-gray-500 mt-1">{{ $perdida->ubicacion ?? '-' }}</div>
                                        <div class="lg:hidden md:block text-xs text-gray-500 mt-1">{{ $perdida->usuario->name }}</div>
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">
                                            {{ ucfirst($perdida->tipo_perdida) }}
                                        </span>
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4 text-sm font-medium text-red-600">
                                        <div>-{{ number_format($perdida->cantidad, 2) }}</div>
                                        <div class="text-xs text-gray-500">{{ $perdida->producto->unidad_medida }}</div>
                                    </td>
                                    <td class="hidden sm:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-900">
                                        @if($perdida->valor_estimado)
                                            ${{ number_format($perdida->valor_estimado, 2) }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td class="hidden md:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-500">
                                        {{ $perdida->ubicacion ?? '-' }}
                                    </td>
                                    <td class="hidden lg:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-500">
                                        {{ $perdida->usuario->name }}
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4 text-sm font-medium">
                                        <div class="flex space-x-1 sm:space-x-2">
                                            <a href="{{ route('inventario.perdidas.edit', $perdida) }}" class="text-green-600 hover:text-green-900" title="Editar">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form id="delete-form-{{ $perdida->id }}" action="{{ route('inventario.perdidas.destroy', $perdida) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete('delete-form-{{ $perdida->id }}')" class="text-red-600 hover:text-red-900" title="Eliminar">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No hay pérdidas registradas
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

                <!-- Paginación -->
                <div class="mt-4">
                    {{ $perdidas->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

