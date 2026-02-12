<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Registrar pago a proveedor — {{ $proveedor->nombre }}</h2>
            <a href="{{ route('cuentas-pagar.show', $proveedor) }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50 text-sm">← Estado de cuenta</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto">
            <p class="text-sm text-gray-600 mb-4">Saldo actual (lo que debemos): <strong class="text-red-600">${{ number_format($saldo, 2) }}</strong></p>
            <div class="bg-white shadow-sm rounded-lg p-6">
                <form method="POST" action="{{ route('cuentas-pagar.pago.store', $proveedor) }}">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Fecha del pago</label>
                            <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
                            @error('fecha')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Monto</label>
                            <input type="number" step="0.01" min="0.01" name="monto" value="{{ old('monto') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required placeholder="0.00">
                            @error('monto')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Forma de pago</label>
                            <input type="text" name="forma_pago" value="{{ old('forma_pago') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Transferencia, Efectivo, Cheque...">
                            @error('forma_pago')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Referencia</label>
                            <input type="text" name="referencia" value="{{ old('referencia') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Número de transferencia, folio...">
                            @error('referencia')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Notas</label>
                            <textarea name="notas" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notas') }}</textarea>
                        </div>
                    </div>
                    <div class="mt-6 flex justify-end space-x-2">
                        <a href="{{ route('cuentas-pagar.show', $proveedor) }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">Registrar pago</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
