<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Boletas de Salida
            </h2>
            <a href="{{ route('boletas-salida.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Nueva Boleta
            </a>
        </div>
    </x-slot>

    @if($boletas->isEmpty())
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="text-center py-12 px-4">
                <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No hay boletas registradas</h3>
                <p class="text-sm text-gray-500 mb-6">Crea una boleta a partir de una orden de carga existente</p>
                <div class="flex justify-center gap-3">
                    <a href="{{ route('boletas-salida.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Crear Boleta
                    </a>
                    <a href="{{ route('ordenes-carga.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium rounded-md transition">
                        Ver Órdenes
                    </a>
                </div>
            </div>
        </div>
    @else
        <div class="bg-white shadow-sm rounded-lg overflow-hidden">
            <div class="overflow-x-auto -mx-4 sm:mx-0">
                <div class="inline-block min-w-full align-middle">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 sm:px-4 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio</th>
                                <th class="px-3 py-2 sm:px-4 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Orden</th>
                                <th class="px-3 py-2 sm:px-4 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operador</th>
                                <th class="hidden xl:table-cell px-3 py-2 sm:px-4 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destino</th>
                                <th class="px-3 py-2 sm:px-4 sm:py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($boletas as $boleta)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-3 py-2 sm:px-4 sm:py-3">
                                        <span class="font-semibold text-blue-600 text-sm">{{ $boleta->folio }}</span>
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 text-sm">{{ $boleta->fecha->format('d/m/Y') }}</td>
                                    <td class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-3">
                                        <a href="{{ route('ordenes-carga.show', $boleta->ordenCarga) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                            {{ $boleta->ordenCarga->folio }}
                                        </a>
                                    </td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3">
                                        <div class="text-sm text-gray-900 font-medium">{{ $boleta->cliente_nombre }}</div>
                                        <div class="md:hidden text-xs text-gray-500 mt-1">Orden: {{ $boleta->ordenCarga->folio }}</div>
                                        <div class="lg:hidden md:block text-xs text-gray-500 mt-1">{{ $boleta->operador_nombre }}</div>
                                        <div class="xl:hidden lg:block text-xs text-gray-500 mt-1">{{ $boleta->destino ?? $boleta->ordenCarga->destino }}</div>
                                    </td>
                                    <td class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-3 text-sm text-gray-600">{{ $boleta->operador_nombre }}</td>
                                    <td class="hidden xl:table-cell px-3 py-2 sm:px-4 sm:py-3 text-sm text-gray-600">{{ $boleta->destino ?? $boleta->ordenCarga->destino }}</td>
                                    <td class="px-3 py-2 sm:px-4 sm:py-3 text-right">
                                        <div class="inline-flex flex-col sm:flex-row gap-1 sm:gap-2">
                                            <a href="{{ route('boletas-salida.show', $boleta) }}" class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm font-medium">Ver</a>
                                            <a href="{{ route('boletas-salida.print', $boleta) }}" target="_blank" class="text-green-600 hover:text-green-800 text-xs sm:text-sm font-medium">Imprimir</a>
                                            <form action="{{ route('boletas-salida.destroy', $boleta) }}" method="POST" class="inline" id="delete-form-boleta-{{ $boleta->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="text-red-600 hover:text-red-800 text-xs sm:text-sm font-medium" onclick="confirmDelete('delete-form-boleta-{{ $boleta->id }}')">Eliminar</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-4">{{ $boletas->links() }}</div>
        </div>
    @endif
</x-app-layout>
