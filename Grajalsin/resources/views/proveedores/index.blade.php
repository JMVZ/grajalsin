<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catálogo de Proveedores</h2>
                <p class="text-sm text-gray-500 mt-1">Gestión</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('gestion.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">← Gestión</a>
                <a href="{{ route('proveedores.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nuevo proveedor</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <x-catalog-toolbar route="proveedores.index" placeholder="Buscar por nombre, RFC o contacto..." />
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                        <th class="hidden md:table-cell px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">RFC</th>
                        <th class="hidden lg:table-cell px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Contacto</th>
                        <th class="hidden sm:table-cell px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cel / Tel</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($proveedores as $proveedor)
                        <tr>
                            <td class="px-4 py-2 font-medium text-gray-900">{{ $proveedor->nombre }}</td>
                            <td class="hidden md:table-cell px-4 py-2 text-sm">{{ $proveedor->rfc ?? '—' }}</td>
                            <td class="hidden lg:table-cell px-4 py-2 text-sm">{{ $proveedor->contacto ?? '—' }}</td>
                            <td class="hidden sm:table-cell px-4 py-2 text-sm">
                                @if($proveedor->celular || $proveedor->telefono)
                                    {{ $proveedor->celular }}@if($proveedor->celular && $proveedor->telefono) / @endif{{ $proveedor->telefono }}
                                @else — @endif
                            </td>
                            <td class="px-4 py-2">
                                @if($proveedor->estatus)
                                    <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Activo</span>
                                @else
                                    <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactivo</span>
                                @endif
                            </td>
                            <td class="px-4 py-2 text-right">
                                <a href="{{ route('proveedores.edit', $proveedor) }}" class="text-blue-600 hover:text-blue-800 text-sm">Editar</a>
                                <form id="delete-proveedor-{{ $proveedor->id }}" action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="inline ml-2">
                                    @csrf @method('DELETE')
                                    <button type="button" class="text-red-600 hover:text-red-800 text-sm" onclick="confirmDelete('delete-proveedor-{{ $proveedor->id }}')">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-gray-500">Sin proveedores registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $proveedores->links() }}
        </div>
    </div>
</x-app-layout>
