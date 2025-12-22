<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de Destinos
        </h2>
    </x-slot>

    <div class="flex justify-between mb-4">
        <a href="{{ route('destinos.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nuevo destino</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Destino</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notas</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($destinos as $destino)
                    <tr>
                        <td class="px-4 py-2 font-semibold">{{ $destino->nombre }}</td>
                        <td class="px-4 py-2">
                            @if($destino->estatus)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ Str::limit($destino->notas, 50) }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('destinos.edit', $destino) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                            <form id="delete-form-{{ $destino->id }}" action="{{ route('destinos.destroy', $destino) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="confirmDelete('delete-form-{{ $destino->id }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">Sin destinos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $destinos->links() }}</div>
    </div>
</x-app-layout>

