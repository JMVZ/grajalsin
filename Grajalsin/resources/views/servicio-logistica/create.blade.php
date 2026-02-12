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
                    <!-- Cliente (búsqueda) -->
                    <div>
                        <label for="cliente_search_input" class="block text-sm font-medium text-gray-700 mb-2">
                            Cliente <span class="text-red-500">*</span> 
                            <span class="text-xs text-gray-400">({{ $clientes->count() }} disponibles)</span>
                        </label>
                        <input type="text" id="cliente_search_input" 
                            placeholder="Escribe para filtrar: nombre, código (G-010) o RFC..."
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500 mb-2">
                        <select name="cliente_id" id="cliente_select" size="8" required
                            class="w-full rounded-md border-gray-300 shadow-sm focus:border-purple-500 focus:ring-purple-500">
                            <option value="">— Seleccione un cliente —</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}" 
                                    data-search="{{ strtolower(($cliente->codigo ?? '') . ' ' . $cliente->nombre . ' ' . ($cliente->rfc ?? '')) }}"
                                    {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
                                    {{ $cliente->codigo ? $cliente->codigo . ' — ' : '' }}{{ $cliente->nombre }}
                                </option>
                            @endforeach
                        </select>
                        <p class="mt-1 text-xs text-gray-500">Haz doble clic en un cliente para seleccionarlo rápidamente.</p>
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

    <script>
        // Filtro simple de clientes sin dependencias externas
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('cliente_search_input');
            const select = document.getElementById('cliente_select');
            
            if (!input || !select) return;
            
            input.addEventListener('input', function() {
                const query = this.value.toLowerCase().trim();
                const options = select.querySelectorAll('option');
                let visibleCount = 0;
                
                options.forEach((opt, i) => {
                    if (i === 0) return; // Skip primera opción "Seleccione..."
                    
                    if (!query) {
                        opt.style.display = '';
                        visibleCount++;
                        return;
                    }
                    
                    const searchText = opt.dataset.search || '';
                    
                    if (searchText.includes(query)) {
                        opt.style.display = '';
                        visibleCount++;
                    } else {
                        opt.style.display = 'none';
                    }
                });
                
                // Auto-seleccionar si solo hay uno visible
                if (visibleCount === 1 && query) {
                    const visible = Array.from(options).find(opt => opt.style.display !== 'none' && opt.value);
                    if (visible) visible.selected = true;
                }
            });
            
            // Doble clic para selección rápida
            select.addEventListener('dblclick', function() {
                if (this.value) {
                    const form = this.closest('form');
                    if (form) {
                        // Enfocar siguiente campo
                        document.getElementById('tipo_unidad')?.focus();
                    }
                }
            });
        });
    </script>
</x-app-layout>
