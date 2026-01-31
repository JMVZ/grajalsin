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
        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="hidden sm:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                            <th class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CURP</th>
                            <th class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Licencia</th>
                            <th class="hidden xl:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vigencia</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($choferes as $chofer)
                            <tr>
                                <td class="px-3 py-2 sm:px-4 sm:py-2">
                                    <div class="text-sm font-medium">{{ $chofer->nombre }}</div>
                                    <div class="sm:hidden text-xs text-gray-500 mt-1">Tel: {{ $chofer->telefono }}</div>
                                    <div class="md:hidden sm:block text-xs text-gray-500 mt-1">CURP: {{ substr($chofer->curp, 0, 13) }}...</div>
                                    <div class="lg:hidden md:block text-xs text-gray-500 mt-1">{{ $chofer->licencia_tipo }} {{ $chofer->licencia_numero }}</div>
                                    <div class="xl:hidden lg:block text-xs text-gray-500 mt-1">Vence: {{ optional($chofer->licencia_vence)->format('d/m/Y') }}</div>
                                </td>
                                <td class="hidden sm:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $chofer->telefono }}</td>
                                <td class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $chofer->curp }}</td>
                                <td class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $chofer->licencia_tipo }} {{ $chofer->licencia_numero }}</td>
                                <td class="hidden xl:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ optional($chofer->licencia_vence)->format('d/m/Y') }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2 text-right">
                                    <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-1 sm:space-y-0">
                                        <a href="{{ route('choferes.edit', $chofer) }}" class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm">Editar</a>
                                        <form id="delete-form-{{ $chofer->id }}" action="{{ route('choferes.destroy', $chofer) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-800 text-xs sm:text-sm" onclick="confirmDelete(event, 'delete-form-{{ $chofer->id }}')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-6 text-center text-gray-500">Sin choferes registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-4">{{ $choferes->links() }}</div>
    </div>
</x-app-layout>


