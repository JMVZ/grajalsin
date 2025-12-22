<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-3xl bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Operaciones de Carga</h2>
                <p class="text-sm text-gray-600 mt-1 font-medium">Flujo completo de gestión de carga</p>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Pre-orden de Carga -->
        <a href="{{ route('pre-ordenes.index') }}" class="group block bg-gradient-to-br from-white to-green-50 border-2 border-green-200 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-green-700">Pre-orden de Carga</h3>
                <div class="w-12 h-12 bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-600 font-medium">Registrar la solicitud inicial y los datos del operador.</p>
            <div class="mt-4 flex items-center text-green-600 text-sm font-semibold">
                <span>Paso 1</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Orden de Carga -->
        <a href="{{ route('ordenes-carga.index') }}" class="group block bg-gradient-to-br from-white to-amber-50 border-2 border-amber-200 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-amber-700">Orden de Carga</h3>
                <div class="w-12 h-12 bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-600 font-medium">Generar la orden oficial a partir de la pre-orden.</p>
            <div class="mt-4 flex items-center text-amber-600 text-sm font-semibold">
                <span>Paso 2</span>
                <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        </a>

        <!-- Boleta de Salida -->
        <a href="{{ route('boletas-salida.index') }}" class="group block bg-gradient-to-br from-white to-blue-50 border-2 border-blue-200 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-blue-700">Boleta de Salida</h3>
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-cyan-600 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
            <p class="text-sm text-gray-600 font-medium">Emitir el documento de salida con análisis y pesaje final.</p>
            <div class="mt-4 flex items-center text-blue-600 text-sm font-semibold">
                <span>Paso 3</span>
            </div>
        </a>
    </div>
</x-app-layout>


