<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catálogo de Bodegas</h2>
    </x-slot>

    <div class="flex justify-between mb-4">
        <a href="{{ route('bodegas.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nueva bodega</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($bodegas as $bodega)
                    <tr>
                        <td class="px-4 py-2">{{ $bodega->nombre }}</td>
                        <td class="px-4 py-2">{{ $bodega->ubicacion }}</td>
                        <td class="px-4 py-2">{{ $bodega->estatus ? 'Activa' : 'Inactiva' }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('bodegas.edit', $bodega) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                            <form id="delete-form-{{ $bodega->id }}" action="{{ route('bodegas.destroy', $bodega) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="confirmDelete(event, 'delete-form-{{ $bodega->id }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Sin bodegas registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $bodegas->links() }}</div>
    </div>
</x-app-layout>


