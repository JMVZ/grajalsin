<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-3xl bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">
                    Pre-orden de Carga
                </h2>
                <p class="text-sm text-gray-600 mt-1 font-medium">Folio: <span class="font-bold text-green-700">{{ $preOrden->folio }}</span></p>
            </div>
            <div class="flex space-x-3 no-print">
                <a href="{{ route('pre-ordenes.edit', $preOrden) }}" class="inline-flex items-center px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Editar
                </a>
                <a href="{{ route('ordenes-carga.create', ['pre_orden' => $preOrden->id]) }}" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 hover:from-amber-600 hover:to-orange-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Generar Orden
                </a>
                <a href="{{ route('pre-ordenes.print', $preOrden) }}" target="_blank" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Imprimir
                </a>
                <a href="{{ route('pre-ordenes.index') }}" class="inline-flex items-center px-5 py-2.5 bg-white border-2 border-gray-200 text-gray-700 font-semibold rounded-xl shadow-md hover:shadow-lg hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    @php
        $chofer = $preOrden->chofer;
        $linea = $preOrden->lineaCarga;
        $destino = $preOrden->destino;
        $cliente = $preOrden->cliente;
        $bodega = $preOrden->base_linea ?? optional($preOrden->bodega)->nombre ?? '';

        $tieneGranel = false;
        $tieneCostal = false;
        $totalToneladas = 0;
        $totalCostales = 0;

        foreach ($preOrden->productos as $producto) {
            if ($producto->pivot->tipo_carga === 'granel') {
                $tieneGranel = true;
                $totalToneladas += $producto->pivot->toneladas ?? 0;
            }
            if ($producto->pivot->tipo_carga === 'costal') {
                $tieneCostal = true;
                $totalCostales += $producto->pivot->cantidad ?? 0;
            }
        }

        $totalToneladas = $tieneGranel ? number_format($totalToneladas, 2) : null;
        $totalCostales = $tieneCostal ? number_format($totalCostales, 2) : null;
    @endphp

    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Header Card con Logo -->
        <div class="bg-gradient-to-br from-white to-gray-50 rounded-2xl shadow-xl border border-gray-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center space-x-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('grajalsin-removebg-preview.png') }}" alt="Grajalsin Logo" class="h-20 w-auto">
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">GRAJALSIN, SPR DE RL</h1>
                        <p class="text-sm text-gray-600">Av Marchal 4014, Fracc. Granada, CP 80058, Culiacán de Rosales, Sinaloa</p>
                        <p class="text-sm text-gray-600">cel. 667 142 6156 y 667 185 6855</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="inline-block bg-gradient-to-r from-green-500 to-emerald-600 text-white px-6 py-3 rounded-xl shadow-lg">
                        <p class="text-xs font-semibold uppercase tracking-wider mb-1">Folio</p>
                        <p class="text-2xl font-bold">{{ $preOrden->folio }}</p>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 pt-4">
                <h2 class="text-2xl font-bold text-gray-800 mb-1">PRE-ORDEN DE CARGA</h2>
                <p class="text-sm text-gray-500">Fecha: {{ $preOrden->fecha->format('d/m/Y') }}</p>
            </div>
        </div>

        <!-- Información del Operador -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Información del Operador
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Operador</label>
                            <p class="text-lg font-bold text-gray-900">{{ strtoupper($chofer->nombre ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Celular</label>
                            <p class="text-base text-gray-700">{{ $chofer->telefono ?? '---' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Licencia</label>
                            <p class="text-base text-gray-700">{{ strtoupper($chofer->licencia_numero ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">CURP</label>
                            <p class="text-base text-gray-700">{{ strtoupper($chofer->curp ?? '---') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Expediente Médico</label>
                            <p class="text-base text-gray-700">{{ strtoupper($chofer->expediente_medico_numero ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Placa Tractor</label>
                            <p class="text-base text-gray-700">{{ strtoupper($preOrden->placa_tractor ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Placa Remolque</label>
                            <p class="text-base text-gray-700">{{ strtoupper($preOrden->placa_remolque ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Modelo</label>
                            <p class="text-base text-gray-700">{{ strtoupper($preOrden->modelo ?? '---') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Carga -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-blue-500 to-cyan-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Información de Carga
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Destino</label>
                            <p class="text-lg font-bold text-gray-900">{{ strtoupper($destino->nombre ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Cliente</label>
                            <p class="text-base text-gray-700">{{ strtoupper($cliente->nombre ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Bodega</label>
                            <p class="text-base text-gray-700">{{ strtoupper($bodega) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Línea</label>
                            <p class="text-base text-gray-700">{{ strtoupper($linea->nombre ?? '---') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Tipo de Carga</label>
                            <div class="flex flex-wrap gap-2 mt-2">
                                @if($tieneGranel)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Granel: {{ $totalToneladas }} TON
                                    </span>
                                @endif
                                @if($tieneCostal)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-blue-100 text-blue-800">
                                        <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Costal: {{ $totalCostales }} UDS
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Tarifa</label>
                            <p class="text-2xl font-bold text-green-600">${{ number_format($preOrden->tarifa ?? 0, 2) }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Póliza Seguro</label>
                            <p class="text-base text-gray-700">{{ strtoupper($preOrden->poliza_seguro ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Criba</label>
                            <p class="text-base text-gray-700">{{ strtoupper($preOrden->criba ?? '---') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Interna -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Información Interna
                </h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Coordinador</label>
                            <p class="text-base text-gray-700">{{ strtoupper($preOrden->coordinador_nombre ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Tel. Coordinador</label>
                            <p class="text-base text-gray-700">{{ $preOrden->coordinador_telefono ?? '---' }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Base de la Línea</label>
                            <p class="text-base text-gray-700">{{ strtoupper($preOrden->base_linea ?? '---') }}</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Constancia Fiscal</label>
                            <p class="text-base text-gray-700">{{ strtoupper($preOrden->constancia_fiscal ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">RFC</label>
                            <p class="text-base text-gray-700">{{ strtoupper($cliente->rfc ?? '---') }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-500 uppercase mb-1">Precio Factura</label>
                            <p class="text-xl font-bold text-purple-600">{{ $preOrden->precio_factura ? '$' . number_format($preOrden->precio_factura, 2) : '---' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Productos -->
        @if($preOrden->productos->count() > 0)
        <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">
            <div class="bg-gradient-to-r from-amber-500 to-orange-600 px-6 py-4">
                <h3 class="text-lg font-bold text-white flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    Detalle de Productos
                </h3>
            </div>
            <div class="p-6">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Producto</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tipo</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Cantidad</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($preOrden->productos as $producto)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-sm font-semibold text-gray-900">{{ strtoupper($producto->nombre) }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-700">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $producto->pivot->tipo_carga === 'granel' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ strtoupper($producto->pivot->tipo_carga) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-bold text-gray-900">
                                        @if($producto->pivot->tipo_carga === 'costal')
                                            {{ number_format($producto->pivot->cantidad ?? 0, 2) }} COSTALES
                                        @else
                                            {{ number_format($producto->pivot->toneladas ?? 0, 2) }} TON
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Notas -->
        @if($preOrden->notas)
        <div class="bg-gradient-to-br from-yellow-50 to-amber-50 rounded-2xl shadow-lg border-2 border-yellow-200 p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-lg font-bold text-yellow-900 mb-2">Notas</h3>
                    <p class="text-sm text-yellow-800 leading-relaxed">{{ $preOrden->notas }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-app-layout>

