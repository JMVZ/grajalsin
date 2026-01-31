<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-purple-800">
                    Servicio de Logística: {{ $servicioLogistica->folio }}
                </h2>
                <p class="text-sm text-purple-600 mt-1">Estado: {{ $servicioLogistica->estado_nombre }}</p>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('servicio-logistica.print', $servicioLogistica) }}" target="_blank" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Imprimir Formato
                </a>
                <a href="{{ route('servicio-logistica.index') }}" 
                    class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Progreso de Pasos -->
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <h3 class="font-semibold text-lg mb-4">Progreso del Proceso</h3>
            <div class="flex flex-wrap gap-4">
                <a href="{{ route('servicio-logistica.paso2', $servicioLogistica) }}" 
                    class="px-4 py-2 rounded-md text-sm font-medium {{ $servicioLogistica->estado !== 'solicitado' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-600' }}">
                    Paso 2: Contactar Línea
                </a>
                <a href="{{ route('servicio-logistica.paso3', $servicioLogistica) }}" 
                    class="px-4 py-2 rounded-md text-sm font-medium {{ in_array($servicioLogistica->estado, ['orden_preparada', 'en_transito', 'en_destino', 'comision_pagada', 'completado']) ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-600' }}">
                    Paso 3: Preparar Orden
                </a>
                <a href="{{ route('servicio-logistica.paso4', $servicioLogistica) }}" 
                    class="px-4 py-2 rounded-md text-sm font-medium {{ in_array($servicioLogistica->estado, ['en_transito', 'en_destino', 'comision_pagada', 'completado']) ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-600' }}">
                    Paso 4: Monitoreo
                </a>
                <a href="{{ route('servicio-logistica.paso5', $servicioLogistica) }}" 
                    class="px-4 py-2 rounded-md text-sm font-medium {{ $servicioLogistica->tiene_carga_retorno ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-600' }}">
                    Paso 5: Carga Retorno
                </a>
            </div>
        </div>

        <!-- Información General -->
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <h3 class="font-semibold text-lg mb-4">Información General</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Cliente</p>
                    <p class="font-medium">{{ $servicioLogistica->cliente->nombre }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tipo de Unidad</p>
                    <p class="font-medium">{{ $servicioLogistica->tipo_unidad_nombre }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Línea de Transporte</p>
                    <p class="font-medium">{{ $servicioLogistica->lineaCarga->nombre ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Tarifa</p>
                    <p class="font-medium">${{ number_format($servicioLogistica->tarifa ?? 0, 2) }}</p>
                </div>
                @if($servicioLogistica->comision_porcentaje)
                <div>
                    <p class="text-sm text-gray-600">Comisión</p>
                    <p class="font-medium">{{ $servicioLogistica->comision_porcentaje }}% (${{ number_format($servicioLogistica->comision_monto ?? 0, 2) }})</p>
                </div>
                @endif
                <div>
                    <p class="text-sm text-gray-600">Estado</p>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                        @if($servicioLogistica->estado === 'completado') bg-green-100 text-green-800
                        @elseif($servicioLogistica->estado === 'comision_pagada') bg-blue-100 text-blue-800
                        @elseif($servicioLogistica->estado === 'en_transito' || $servicioLogistica->estado === 'en_destino') bg-yellow-100 text-yellow-800
                        @elseif($servicioLogistica->estado === 'orden_preparada') bg-purple-100 text-purple-800
                        @else bg-gray-100 text-gray-800
                        @endif">
                        {{ $servicioLogistica->estado_nombre }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Datos del Operador y Vehículo -->
        @if($servicioLogistica->operador_nombre)
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <h3 class="font-semibold text-lg mb-4">Datos del Operador y Vehículo</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm text-gray-600">Operador</p>
                    <p class="font-medium">{{ $servicioLogistica->operador_nombre }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Celular</p>
                    <p class="font-medium">{{ $servicioLogistica->operador_celular ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Licencia</p>
                    <p class="font-medium">{{ $servicioLogistica->operador_licencia_numero ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">CURP/RFC</p>
                    <p class="font-medium">{{ $servicioLogistica->operador_curp_rfc ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Placa Tractor</p>
                    <p class="font-medium">{{ $servicioLogistica->placa_tractor ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600">Placa Remolque</p>
                    <p class="font-medium">{{ $servicioLogistica->placa_remolque ?? '-' }}</p>
                </div>
            </div>
        </div>
        @endif

        <!-- Notas -->
        @if($servicioLogistica->notas_monitoreo || $servicioLogistica->notas_retorno || $servicioLogistica->notas_internas)
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <h3 class="font-semibold text-lg mb-4">Notas</h3>
            @if($servicioLogistica->notas_monitoreo)
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700 mb-1">Monitoreo:</p>
                <p class="text-sm text-gray-600">{{ $servicioLogistica->notas_monitoreo }}</p>
            </div>
            @endif
            @if($servicioLogistica->notas_retorno)
            <div class="mb-4">
                <p class="text-sm font-medium text-gray-700 mb-1">Retorno:</p>
                <p class="text-sm text-gray-600">{{ $servicioLogistica->notas_retorno }}</p>
            </div>
            @endif
            @if($servicioLogistica->notas_internas)
            <div>
                <p class="text-sm font-medium text-gray-700 mb-1">Internas:</p>
                <p class="text-sm text-gray-600">{{ $servicioLogistica->notas_internas }}</p>
            </div>
            @endif
        </div>
        @endif
    </div>
</x-app-layout>

