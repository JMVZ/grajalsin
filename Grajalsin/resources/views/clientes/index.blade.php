<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Catálogo de Clientes
        </h2>
    </x-slot>

    <div class="flex justify-between mb-4">
        <a href="{{ route('clientes.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nuevo cliente</a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="overflow-x-auto -mx-4 sm:mx-0">
            <div class="inline-block min-w-full align-middle">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                            <th class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">RFC</th>
                            <th class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contacto</th>
                            <th class="hidden sm:table-cell px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estatus</th>
                            <th class="px-3 py-2 sm:px-4 sm:py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($clientes as $cliente)
                            <tr>
                                <td class="px-3 py-2 sm:px-4 sm:py-2 font-semibold text-green-700 text-sm">{{ $cliente->codigo }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2">
                                    <div class="text-sm font-medium">{{ $cliente->nombre }}</div>
                                    <div class="md:hidden text-xs text-gray-500 mt-1">RFC: {{ $cliente->rfc }}</div>
                                    <div class="lg:hidden md:block text-xs text-gray-500 mt-1">Contacto: {{ $cliente->contacto }}</div>
                                    <div class="sm:hidden text-xs text-gray-500 mt-1">Tel: {{ $cliente->telefono }}</div>
                                </td>
                                <td class="hidden md:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $cliente->rfc }}</td>
                                <td class="hidden lg:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $cliente->contacto }}</td>
                                <td class="hidden sm:table-cell px-3 py-2 sm:px-4 sm:py-2 text-sm">{{ $cliente->telefono }}</td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2">
                                    @if($cliente->estatus)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Activo</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Inactivo</span>
                                    @endif
                                </td>
                                <td class="px-3 py-2 sm:px-4 sm:py-2 text-right">
                                    <div class="flex flex-col sm:flex-row sm:space-x-2 space-y-1 sm:space-y-0">
                                        <a href="{{ route('clientes.edit', $cliente) }}" class="text-blue-600 hover:text-blue-800 text-xs sm:text-sm">Editar</a>
                                        <form id="delete-form-{{ $cliente->id }}" action="{{ route('clientes.destroy', $cliente) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="text-red-600 hover:text-red-800 text-xs sm:text-sm" onclick="confirmDelete('delete-form-{{ $cliente->id }}')">Eliminar</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-gray-500">Sin clientes registrados</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="p-4">{{ $clientes->links() }}</div>
    </div>
</x-app-layout>




