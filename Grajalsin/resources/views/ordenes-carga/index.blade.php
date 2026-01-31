<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Órdenes de Carga
            </h2>
            <a href="{{ route('ordenes-carga.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Nueva orden
            </a>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                            <th class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operador</th>
                            <th class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destino</th>
                            <th class="hidden sm:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Presentación</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($ordenes as $orden)
                            <tr>
                                <td class="px-3 py-2 sm:px-4 sm:py-2 font-semibold text-green-700 text-sm">{{ $orden->folio }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $orden->fecha_entrada->format('d/m/Y') }}</td>
                                <td class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $orden->operador_nombre }}</td>
                                <td class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $orden->destino }}</td>
                                <td class="hidden sm:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm text-gray-600">{{ $orden->presentacion }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2">
                                    <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-1 sm:space-y-0 text-right">
                                        <a href="{{ route('ordenes-carga.show', $orden) }}" class="text-green-600 hover:text-green-800 text-xs sm:text-sm">Ver</a>
                                        <a href="{{ route('ordenes-carga.print', $orden) }}" target="_blank" class="text-gray-600 hover:text-gray-800 text-xs sm:text-sm">Imprimir</a>
                                        <form action="{{ route('ordenes-carga.destroy', $orden) }}" method="POST" class="inline" id="delete-form-orden-{{ $orden->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-800 text-xs sm:text-sm" onclick="confirmDelete('delete-form-orden-{{ $orden->id }}')">Eliminar</button>
                                        </form>
                                    </div>
                                    <div class="md:hidden text-xs text-gray-500 mt-1">
                                        <div>{{ $orden->operador_nombre }}</div>
                                        <div class="lg:hidden">{{ $orden->destino }}</div>
                                        <div class="sm:hidden">{{ $orden->presentacion }}</div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">Sin órdenes registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-4">{{ $ordenes->links() }}</div>
    </div>
</x-app-layout>


