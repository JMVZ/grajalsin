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
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Operador</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destino</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($preOrdenes as $preOrden)
                    <tr>
                        <td class="px-4 py-2 font-semibold text-green-700">{{ $preOrden->folio ?? 'S/F' }}</td>
                        <td class="px-4 py-2">{{ $preOrden->fecha->format('d/m/Y') }}</td>
                        <td class="px-4 py-2">{{ $preOrden->chofer->nombre }}</td>
                        <td class="px-4 py-2">{{ $preOrden->destino->nombre }}</td>
                        <td class="px-4 py-2 font-semibold">{{ $preOrden->cliente->nombre }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('pre-ordenes.show', $preOrden) }}" class="text-green-600 hover:text-green-800">Ver</a>
                            <a href="{{ route('pre-ordenes.edit', $preOrden) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                            <form id="delete-form-{{ $preOrden->id }}" action="{{ route('pre-ordenes.destroy', $preOrden) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="confirmDelete('delete-form-{{ $preOrden->id }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Sin pre-órdenes registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $preOrdenes->links() }}</div>
    </div>
</x-app-layout>

