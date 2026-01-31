<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Pre-órdenes de Carga
        </h2>
    </x-slot>

    <div class="flex justify-between mb-4">
        <a href="{{ route('pre-ordenes.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nueva pre-orden</a>
    </div>

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
                            <th class="px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($preOrdenes as $preOrden)
                            <tr>
                                <td class="px-3 py-2 sm:px-4 sm:py-2 font-semibold text-green-700">{{ $preOrden->folio ?? 'S/F' }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $preOrden->fecha->format('d/m/Y') }}</td>
                                <td class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $preOrden->chofer->nombre }}</td>
                                <td class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $preOrden->destino->nombre }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2">
                                    <div class="font-semibold text-sm">{{ $preOrden->cliente->nombre }}</div>
                                    <div class="md:hidden text-xs text-gray-500 mt-1">{{ $preOrden->chofer->nombre }}</div>
                                    <div class="lg:hidden md:block text-xs text-gray-500 mt-1">{{ $preOrden->destino->nombre }}</div>
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2 text-right">
                                    <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-1 sm:space-y-0">
                                        <a href="{{ route('pre-ordenes.show', $preOrden) }}" class="text-green-600 hover:text-green-800 text-xs sm:text-sm">Ver</a>
                                        <a href="{{ route('pre-ordenes.edit', $preOrden) }}" class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm">Editar</a>
                                        <form id="delete-form-{{ $preOrden->id }}" action="{{ route('pre-ordenes.destroy', $preOrden) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-800 text-xs sm:text-sm" onclick="confirmDelete('delete-form-{{ $preOrden->id }}')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">Sin pre-órdenes registradas</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-4">{{ $preOrdenes->links() }}</div>
    </div>
</x-app-layout>

