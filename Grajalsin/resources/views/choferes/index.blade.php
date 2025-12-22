<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de Choferes
        </h2>
    </x-slot>

    <div class="flex justify-between mb-4">
        <a href="{{ route('choferes.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nuevo chofer</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CURP</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Licencia</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vigencia</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($choferes as $chofer)
                    <tr>
                        <td class="px-4 py-2">{{ $chofer->nombre }}</td>
                        <td class="px-4 py-2">{{ $chofer->telefono }}</td>
                        <td class="px-4 py-2">{{ $chofer->curp }}</td>
                        <td class="px-4 py-2">{{ $chofer->licencia_tipo }} {{ $chofer->licencia_numero }}</td>
                        <td class="px-4 py-2">{{ optional($chofer->licencia_vence)->format('d/m/Y') }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('choferes.edit', $chofer) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                            <form id="delete-form-{{ $chofer->id }}" action="{{ route('choferes.destroy', $chofer) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="confirmDelete(event, 'delete-form-{{ $chofer->id }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Sin choferes registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4">{{ $choferes->links() }}</div>
    </div>
</x-app-layout>


