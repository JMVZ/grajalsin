<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de Líneas de Carga
        </h2>
    </x-slot>

    <div class="flex justify-between mb-4">
        <a href="{{ route('lineas-carga.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nueva línea de carga</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <x-catalog-toolbar route="lineas-carga.index" placeholder="Buscar por nombre o contacto..." />
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Base</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notas</th>
                    <th class="px-4 py-2"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($lineas as $linea)
                    <tr>
                        <td class="px-4 py-2">{{ $linea->nombre }}</td>
                        <td class="px-4 py-2">{{ $linea->contacto }}</td>
                        <td class="px-4 py-2">{{ $linea->base_operacion }}</td>
                        <td class="px-4 py-2">
                            @if($linea->estatus)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ Str::limit($linea->notas, 50) }}</td>
                        <td class="px-4 py-2 text-right space-x-2">
                            <a href="{{ route('lineas-carga.edit', $linea) }}" class="text-blue-600 hover:text-blue-800">Editar</a>
                            <form id="delete-form-{{ $linea->id }}" action="{{ route('lineas-carga.destroy', $linea) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="text-red-600 hover:text-red-800" onclick="confirmDelete('delete-form-{{ $linea->id }}')">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Sin líneas de carga registradas</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <div class="p-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
            {{ $lineas->links() }}
        </div>
    </div>
</x-app-layout>

