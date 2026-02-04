<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pedidos de Venta</h2>
                <p class="text-sm text-gray-500 mt-1">Módulo de Ventas</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('ventas.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">← Ventas</a>
                <a href="{{ route('ventas.pedidos.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Nuevo Pedido</a>
            </div>
        </div>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="flex flex-col sm:flex-row gap-4 p-4 border-b border-gray-200">
            <form method="GET" action="{{ route('ventas.pedidos.index') }}" class="flex flex-1 gap-2 flex-wrap items-center">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por folio o cliente..." class="block flex-1 min-w-[150px] rounded-md border-gray-300 text-sm focus:border-green-500 focus:ring-green-500">
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
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cliente</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Cantidad</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha entrega</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estatus</th>
                        <th class="px-4 py-2"></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse($pedidos as $pedido)
                        <tr>
                            <td class="px-4 py-2 font-semibold text-green-700">{{ $pedido->folio }}</td>
                            <td class="px-4 py-2 text-sm">{{ $pedido->cliente->nombre }}</td>
                            <td class="px-4 py-2 text-sm">
                                @if($pedido->producto && $pedido->producto->tipo_producto === 'costal')
                                    {{ number_format($pedido->toneladas, 0) }} costales
                                @else
                                    {{ number_format($pedido->toneladas, 2) }} ton
                                @endif
                            </td>
                            <td class="px-4 py-2 text-sm">{{ $pedido->fecha->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm">{{ $pedido->fecha_entrega->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 text-sm font-medium">${{ number_format($pedido->importe_total, 2) }}</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs rounded-full
                                    @if($pedido->estatus === 'activa') bg-green-100 text-green-800
                                    @else bg-red-100 text-red-800 @endif">
                                    {{ ucfirst($pedido->estatus) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">
                                <a href="{{ route('ventas.pedidos.show', $pedido) }}" class="text-green-600 hover:text-green-800 text-sm">Ver</a>
                                @if($pedido->estatus === 'activa')
                                    <a href="{{ route('ventas.pedidos.edit', $pedido) }}" class="text-blue-600 hover:text-blue-800 text-sm ml-2">Editar</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-4 py-6 text-center text-gray-500">No hay pedidos de venta</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            {{ $pedidos->links() }}
        </div>
    </div>
</x-app-layout>
