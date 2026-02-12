<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cuentas por pagar — Estado de cuenta con proveedores</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto">
            <p class="text-sm text-gray-600 mb-4">Compras a <strong>crédito</strong> se cargan aquí. Registre los pagos a proveedores para llevar el estado de cuenta.</p>
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <form method="GET" action="{{ route('cuentas-pagar.index') }}" class="p-4 border-b border-gray-200 flex flex-wrap gap-2 items-center">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar por nombre o RFC..." class="rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500 text-sm">
                    <button type="submit" class="px-3 py-1.5 bg-gray-100 rounded-md text-sm hover:bg-gray-200">Buscar</button>
                </form>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Proveedor</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Saldo (lo que debemos)</th>
                            <th class="px-4 py-2"></th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($proveedores as $proveedor)
                            <tr>
                                <td class="px-4 py-2 font-medium">{{ $proveedor->nombre }}</td>
                                <td class="px-4 py-2 text-right font-semibold {{ $proveedor->saldo_cuenta > 0 ? 'text-red-600' : 'text-gray-500' }}">
                                    ${{ number_format($proveedor->saldo_cuenta, 2) }}
                                </td>
                                <td class="px-4 py-2 text-right">
                                    <a href="{{ route('cuentas-pagar.show', $proveedor) }}" class="text-green-600 hover:text-green-800 text-sm">Estado de cuenta</a>
                                    @if($proveedor->saldo_cuenta > 0)
                                        <span class="mx-1">|</span>
                                        <a href="{{ route('cuentas-pagar.pago.create', $proveedor) }}" class="text-blue-600 hover:text-blue-800 text-sm">Registrar pago</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-gray-500">No hay proveedores con estado de cuenta o no hay movimientos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    {{ $proveedores->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
