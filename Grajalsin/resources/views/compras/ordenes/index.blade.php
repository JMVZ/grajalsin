<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Órdenes de Compra</h2>
                <p class="text-sm text-gray-500 mt-1">Módulo de Compras</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('compras.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">← Compras</a>
                <a href="{{ route('compras.ordenes.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nueva Orden</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="flex flex-col sm:flex-row gap-4 p-4 border-b border-gray-200">
            <form method="GET" action="{{ route('compras.ordenes.index') }}" class="flex flex-1 gap-2 flex-wrap items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por folio o proveedor..." class="block flex-1 min-w-[150px] rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
                <select name="tipo" class="rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
                    <option value="">Todos los tipos</option>
                    <option value="insumos" {{ request('tipo') === 'insumos' ? 'selected' : '' }}>Insumos</option>
                    <option value="granos" {{ request('tipo') === 'granos' ? 'selected' : '' }}>Granos</option>
                </select>
                <select name="per_page" onchange="this.form.submit()" class="rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
                    @foreach([10, 15, 25, 50] as $n)
                        <option value="{{ $n }}" {{ (int) request('per_page', 15) === $n ? 'selected' : '' }}>{{ $n }} por página</option>
                    @endforeach
                </select>
                <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">Buscar</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Folio</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tipo</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Proveedor</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($ordenes as $orden)
                        <tr>
                            <td class="px-4 py-2 font-semibold text-green-700">{{ $orden->folio }}</td>
                            <td class="px-4 py-2 text-sm">{{ ucfirst($orden->tipo) }}</td>
                            <td class="px-4 py-2 text-sm">{{ $orden->proveedor->nombre }}</td>
                            <td class="px-4 py-2 text-sm">{{ $orden->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm font-medium">${{ number_format($orden->total, 2) }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($orden->estatus === 'activa') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($orden->estatus) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('compras.ordenes.show', $orden) }}" class="text-green-600 hover:text-green-800 text-sm">Ver</a>
                                @if($orden->estatus === 'activa')
                                    <a href="{{ route('compras.ordenes.edit', $orden) }}" class="text-blue-600 hover:text-blue-800 text-sm ml-2">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-4 py-6 text-center text-gray-500">No hay órdenes de compra</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $ordenes->links() }}
        </div>
    </div>
</x-app-layout>
