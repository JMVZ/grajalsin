<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Estado de cuenta — {{ $proveedor->nombre }}</h2>
            <div class="flex space-x-2">
                <a href="{{ route('cuentas-pagar.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">← Cuentas por pagar</a>
                @if($saldo > 0)
                    <a href="{{ route('cuentas-pagar.pago.create', $proveedor) }}" class="px-4 py-2 bg-green-600 text-white rounded-md text-sm hover:bg-green-700">Registrar pago</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto">
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded-md text-sm">{{ session('success') }}</div>
            @endif
            <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
                <p class="text-sm text-gray-500">Saldo (lo que Grajalsin debe al proveedor)</p>
                <p class="text-2xl font-bold {{ $saldo > 0 ? 'text-red-600' : 'text-gray-700' }}">${{ number_format($saldo, 2) }}</p>
            </div>
            <div class="bg-white shadow-sm rounded-lg overflow-hidden">
                <h3 class="px-4 py-3 bg-gray-50 font-medium text-gray-800">Movimientos</h3>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Concepto</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Notas</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Cargo</th>
                            <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase">Abono</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($proveedor->movimientosCuenta as $mov)
                            <tr>
                                <td class="px-4 py-2 text-sm">{{ $mov->fecha->format('d/m/Y') }}</td>
                                <td class="px-4 py-2 text-sm">{{ ucfirst($mov->concepto) }}</td>
                                <td class="px-4 py-2 text-sm text-gray-600">{{ Str::limit($mov->notas, 40) }}</td>
                                <td class="px-4 py-2 text-sm text-right">{{ $mov->tipo === 'cargo' ? '$' . number_format($mov->monto, 2) : '—' }}</td>
                                <td class="px-4 py-2 text-sm text-right text-green-600">{{ $mov->tipo === 'abono' ? '$' . number_format($mov->monto, 2) : '—' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-gray-500">Sin movimientos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
