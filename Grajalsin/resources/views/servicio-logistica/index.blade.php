<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-purple-800">
                    Servicios de Logística CATTA
                </h2>
                <p class="text-sm text-purple-600 mt-1">Gestión de servicios de transporte de carga pesada</p>
            </div>
            <a href="{{ route('servicio-logistica.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Nuevo Servicio
            </a>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Lista de Servicios -->
        <div class="bg-white shadow rounded-lg border border-purple-200">
            <div class="px-4 py-5 sm:p-6">
                <div class="overflow-x-auto -mx-4 sm:mx-0">
                    <div class="inline-block min-w-full align-middle">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Folio</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                    <th class="hidden md:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipo Unidad</th>
                                    <th class="hidden lg:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Línea</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                                    <th class="hidden sm:table-cell px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tarifa</th>
                                    <th class="px-3 py-2 sm:px-6 sm:py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($servicios as $servicio)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-3 sm:px-6 sm:py-4">
                                            <div class="text-sm font-semibold text-purple-700">{{ $servicio->folio }}</div>
                                            <div class="text-xs text-gray-500 sm:hidden">{{ $servicio->tipo_unidad_nombre }}</div>
                                        </td>
                                        <td class="px-3 py-3 sm:px-6 sm:py-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $servicio->cliente->nombre ?? '' }}</div>
                                            <div class="lg:hidden md:block text-xs text-gray-500 mt-1">{{ $servicio->lineaCarga->nombre ?? '' }}</div>
                                            <div class="sm:hidden text-xs text-gray-500 mt-1">${{ number_format($servicio->tarifa ?? 0, 2) }}</div>
                                        </td>
                                        <td class="hidden md:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-900">
                                            {{ $servicio->tipo_unidad_nombre }}
                                        </td>
                                        <td class="hidden lg:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-500">
                                            {{ $servicio->lineaCarga->nombre ?? '-' }}
                                        </td>
                                        <td class="px-3 py-3 sm:px-6 sm:py-4">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                @if($servicio->estado === 'completado') bg-green-100 text-green-800
                                                @elseif($servicio->estado === 'comision_pagada') bg-blue-100 text-blue-800
                                                @elseif($servicio->estado === 'en_transito' || $servicio->estado === 'en_destino') bg-yellow-100 text-yellow-800
                                                @elseif($servicio->estado === 'orden_preparada') bg-purple-100 text-purple-800
                                                @else bg-gray-100 text-gray-800
                                                @endif">
                                                {{ $servicio->estado_nombre }}
                                            </span>
                                        </td>
                                        <td class="hidden sm:table-cell px-3 py-3 sm:px-6 sm:py-4 text-sm text-gray-900">
                                            ${{ number_format($servicio->tarifa ?? 0, 2) }}
                                        </td>
                                        <td class="px-3 py-3 sm:px-6 sm:py-4 text-sm font-medium">
                                            <div class="flex space-x-1 sm:space-x-2">
                                                <a href="{{ route('servicio-logistica.show', $servicio) }}" class="text-purple-600 hover:text-purple-900" title="Ver">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                    </svg>
                                                </a>
                                                <a href="{{ route('servicio-logistica.print', $servicio) }}" target="_blank" class="text-green-600 hover:text-green-900" title="Imprimir">
                                                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500">
                                            No hay servicios registrados. 
                                            <a href="{{ route('servicio-logistica.create') }}" class="text-purple-600 hover:text-purple-700 font-medium">Crear el primero</a>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Paginación -->
                <div class="mt-4">
                    {{ $servicios->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

