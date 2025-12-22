<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Boleta de Salida {{ $boleta->folio }}
                </h2>
                <p class="text-sm text-gray-600">Derivada de la orden de carga {{ $boleta->ordenCarga->folio }}</p>
            </div>
            <div class="flex space-x-2">
                <form action="{{ route('boletas-salida.destroy', $boleta) }}" method="POST" onsubmit="return confirm('¿Eliminar esta boleta de salida?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">Eliminar</button>
                </form>
                <a href="{{ route('boletas-salida.print', $boleta) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Imprimir</a>
                <a href="{{ route('boletas-salida.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Datos Generales -->
        <div class="bg-white shadow-sm rounded-lg p-6 space-y-3">
            <h3 class="text-sm font-semibold text-gray-700 uppercase">Datos Generales</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                <div>
                    <dt class="font-semibold text-gray-600">Fecha</dt>
                    <dd class="text-gray-800">{{ $boleta->fecha->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Cliente Tipo</dt>
                    <dd class="text-gray-800">{{ $boleta->cliente_tipo ?: '---' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="font-semibold text-gray-600">Cliente Nombre</dt>
                    <dd class="text-gray-800">{{ $boleta->cliente_nombre }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">RFC</dt>
                    <dd class="text-gray-800">{{ $boleta->cliente_rfc ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Producto</dt>
                    <dd class="text-gray-800">{{ $boleta->producto }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Variedad</dt>
                    <dd class="text-gray-800">{{ $boleta->variedad ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Cosecha</dt>
                    <dd class="text-gray-800">{{ $boleta->cosecha ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Envase</dt>
                    <dd class="text-gray-800">{{ $boleta->envase ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Origen</dt>
                    <dd class="text-gray-800">{{ $boleta->origen ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Destino</dt>
                    <dd class="text-gray-800">{{ $boleta->destino ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Referencia</dt>
                    <dd class="text-gray-800">{{ $boleta->referencia ?: '---' }}</dd>
                </div>
            </dl>
        </div>

        <!-- Datos del Operador -->
        <div class="bg-white shadow-sm rounded-lg p-6 space-y-3">
            <h3 class="text-sm font-semibold text-gray-700 uppercase">Datos del Operador y Unidad</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                <div>
                    <dt class="font-semibold text-gray-600">Operador</dt>
                    <dd class="text-gray-800">{{ $boleta->operador_nombre }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Celular</dt>
                    <dd class="text-gray-800">{{ $boleta->operador_celular ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Licencia</dt>
                    <dd class="text-gray-800">{{ $boleta->operador_licencia ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">RFC / CURP</dt>
                    <dd class="text-gray-800">{{ $boleta->operador_curp ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Camión</dt>
                    <dd class="text-gray-800">{{ $boleta->camion ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Placas</dt>
                    <dd class="text-gray-800">{{ $boleta->placas ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Póliza</dt>
                    <dd class="text-gray-800">{{ $boleta->poliza ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Línea</dt>
                    <dd class="text-gray-800">{{ $boleta->linea ?: '---' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Análisis del Producto -->
    <div class="bg-white shadow-sm rounded-lg p-6 mt-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase mb-3">Análisis del Producto</h3>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 text-sm">
            <div>
                <dt class="font-semibold text-gray-600">Humedad</dt>
                <dd class="text-gray-800">{{ $boleta->analisis_humedad ? number_format($boleta->analisis_humedad, 2) . '%' : '---' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-600">P. Específico</dt>
                <dd class="text-gray-800">{{ $boleta->analisis_peso_especifico ? number_format($boleta->analisis_peso_especifico, 2) : '---' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-600">Impurezas</dt>
                <dd class="text-gray-800">{{ $boleta->analisis_impurezas ? number_format($boleta->analisis_impurezas, 2) . '%' : '---' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-600">Quebrado</dt>
                <dd class="text-gray-800">{{ $boleta->analisis_quebrado ? number_format($boleta->analisis_quebrado, 2) . '%' : '---' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-600">Dañados</dt>
                <dd class="text-gray-800">{{ $boleta->analisis_danados ? number_format($boleta->analisis_danados, 2) . '%' : '---' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-600">Otros</dt>
                <dd class="text-gray-800">{{ $boleta->analisis_otros ? number_format($boleta->analisis_otros, 2) . '%' : '---' }}</dd>
            </div>
        </div>
    </div>

    <!-- Peso Báscula -->
    <div class="bg-white shadow-sm rounded-lg p-6 mt-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase mb-3">Peso Báscula</h3>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
            <div>
                <dt class="font-semibold text-gray-600">Peso Bruto</dt>
                <dd class="text-gray-800">{{ $boleta->peso_bruto ? number_format($boleta->peso_bruto, 2) : '---' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-600">Peso Tara</dt>
                <dd class="text-gray-800">{{ $boleta->peso_tara ? number_format($boleta->peso_tara, 2) : '---' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-600">Peso Neto</dt>
                <dd class="text-gray-800">{{ $boleta->peso_neto ? number_format($boleta->peso_neto, 2) : '---' }}</dd>
            </div>
            <div>
                <dt class="font-semibold text-gray-600">Peso Total</dt>
                <dd class="text-gray-800">{{ $boleta->peso_total ? number_format($boleta->peso_total, 2) : '---' }}</dd>
            </div>
        </div>
    </div>

    <!-- Observaciones y Firmas -->
    <div class="bg-white shadow-sm rounded-lg p-6 mt-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase mb-3">Observaciones</h3>
        <p class="text-sm text-gray-800">{{ $boleta->observaciones ?: 'Sin observaciones' }}</p>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mt-6 pt-6 border-t border-gray-200">
            <div class="space-y-2">
                <p class="font-semibold text-gray-600 uppercase">Elaboró</p>
                <p class="text-gray-800">{{ $boleta->elaboro_nombre ?: '---' }}</p>
            </div>
            <div class="space-y-2">
                <p class="font-semibold text-gray-600 uppercase">Firma Recibió</p>
                <p class="text-gray-800">{{ $boleta->firma_recibio_nombre ?: '---' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
