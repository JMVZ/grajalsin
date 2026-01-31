<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-purple-800">
                    Paso 1: Nueva Solicitud de Servicio
                </h2>
                <p class="text-sm text-purple-600 mt-1">Cliente solicita unidad para carga</p>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg border border-purple-200 p-6">
            <form action="{{ route('servicio-logistica.store') }}" method="POST">
                @csrf

                <div class="space-y-6">
                    <!-- Cliente -->
                    <div>
                        <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-2">
                            Cliente <span class="text-red-500">*</span>
                        </label>
                        <select name="cliente_id" id="cliente_id" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">Seleccione un cliente</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('cliente_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Unidad -->
                    <div>
                        <label for="tipo_unidad" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Unidad <span class="text-red-500">*</span>
                        </label>
                        <select name="tipo_unidad" id="tipo_unidad" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="caja_seca" {{ old('tipo_unidad') == 'caja_seca' ? 'selected' : '' }}>Caja Seca</option>
                            <option value="thermo" {{ old('tipo_unidad') == 'thermo' ? 'selected' : '' }}>Thermo</option>
                            <option value="jaula" {{ old('tipo_unidad') == 'jaula' ? 'selected' : '' }}>Jaula</option>
                            <option value="plataforma" {{ old('tipo_unidad') == 'plataforma' ? 'selected' : '' }}>Plataforma</option>
                        </select>
                        @error('tipo_unidad')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tipo de Carga -->
                    <div>
                        <label for="tipo_carga" class="block text-sm font-medium text-gray-700 mb-2">
                            Tipo de Carga <span class="text-red-500">*</span>
                        </label>
                        <select name="tipo_carga" id="tipo_carga" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="simple" {{ old('tipo_carga') == 'simple' ? 'selected' : '' }}>Carga Simple</option>
                            <option value="completa" {{ old('tipo_carga') == 'completa' ? 'selected' : '' }}>Carga Completa</option>
                        </select>
                        @error('tipo_carga')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Botones -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <a href="{{ route('servicio-logistica.index') }}" 
                            class="px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50">
                            Cancelar
                        </a>
                        <button type="submit" 
                            class="px-4 py-2 bg-purple-600 text-white rounded-md text-sm font-medium hover:bg-purple-700">
                            Continuar al Paso 2
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

