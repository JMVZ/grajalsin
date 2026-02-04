<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-green-800">
                    Productos / Granos
                </h2>
                <p class="text-sm text-green-600 mt-1">Catálogo de productos</p>
            </div>
            <a href="{{ route('inventario.productos.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Producto
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Lista de Productos -->
        <div class="bg-white shadow rounded-lg border border-green-200 overflow-hidden">
            <x-catalog-toolbar route="inventario.productos" placeholder="Buscar por nombre, código o descripción..." />
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th class="hidden sm:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Compra</th>
                                    <th class="hidden md:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio Venta</th>
                                    <th class="hidden lg:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($productos as $producto)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-3 py-3 sm:px-6 sm:py-4">
                                        <div class="flex items-center">
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $producto->nombre }}</div>
                                                @if($producto->codigo)
                                                    <div class="text-xs text-gray-500">Código: {{ $producto->codigo }}</div>
                                                @endif
                                                <div class="sm:hidden mt-1">
                                                    @if($producto->precio_compra)
                                                        <span class="text-xs text-gray-600">Compra: ${{ number_format($producto->precio_compra, 2) }}</span>
                                                    @endif
                                                    @if($producto->precio_venta)
                                                        <span class="text-xs text-gray-600 ml-2">Venta: ${{ number_format($producto->precio_venta, 2) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4">
                                        @if($producto->maneja_stock)
                                            <div class="text-sm font-medium text-gray-900">{{ number_format($producto->stock_actual, 2) }} {{ $producto->unidad_medida }}</div>
                                            @if($producto->isStockBajo())
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 mt-1">
                                                    ⚠️ Bajo
                                                </span>
                                            @endif
                                        @else
                                            <div class="flex flex-col">
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                                    Sin stock
                                                </span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="hidden sm:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-900">
                                        ${{ number_format($producto->precio_compra ?? 0, 2) }}
                                    </td>
                                    <td class="hidden md:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-900">
                                        ${{ number_format($producto->precio_venta ?? 0, 2) }}
                                    </td>
                                    <td class="hidden lg:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-500">
                                        {{ $producto->ubicacion ?? '-' }}
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4">
                                        @if($producto->activo)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                Activo
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                Inactivo
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-3 sm:px-6 sm:py-4 text-sm font-medium">
                                        <div class="flex space-x-1 sm:space-x-2">
                                            <a href="{{ route('inventario.productos.edit', $producto) }}" class="text-green-600 hover:text-green-900" title="Editar">
                                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                            </a>
                                            <form id="delete-form-{{ $producto->id }}" action="{{ route('inventario.productos.destroy', $producto) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" onclick="confirmDelete('delete-form-{{ $producto->id }}')" class="text-red-600 hover:text-red-900" title="Eliminar">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                        No hay productos registrados. 
                                        <a href="{{ route('inventario.productos.create') }}" class="text-green-600 hover:text-green-700 font-medium">Crear el primero</a>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-4 border-t border-gray-200 bg-gray-50 rounded-b-lg">
                {{ $productos->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

