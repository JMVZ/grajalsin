<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Orden de Carga {{ $orden->folio }}
                </h2>
                <p class="text-sm text-gray-600">Derivada de la pre-orden {{ $orden->preOrden->folio }}</p>
            </div>
            <div class="flex space-x-2">
                @if($orden->boletaSalida)
                    <a href="{{ route('boletas-salida.show', $orden->boletaSalida) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Ver Boleta</a>
                @else
                    <a href="{{ route('boletas-salida.create', ['orden' => $orden->id]) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">Generar Boleta</a>
                @endif
                <form action="{{ route('ordenes-carga.destroy', $orden) }}" method="POST" onsubmit="return confirm('¿Eliminar esta orden de carga?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">Eliminar</button>
                </form>
                <a href="{{ route('ordenes-carga.print', $orden) }}" target="_blank" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">Imprimir</a>
                <a href="{{ route('ordenes-carga.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white shadow-sm rounded-lg p-6 space-y-3">
            <h3 class="text-sm font-semibold text-gray-700 uppercase">Datos generales</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                <div>
                    <dt class="font-semibold text-gray-600">Fecha entrada</dt>
                    <dd class="text-gray-800">{{ $orden->fecha_entrada->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Origen</dt>
                    <dd class="text-gray-800">{{ $orden->origen ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Bodega</dt>
                    <dd class="text-gray-800">{{ $orden->bodega ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Destino</dt>
                    <dd class="text-gray-800">{{ $orden->destino ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Peso</dt>
                    <dd class="text-gray-800">{{ $orden->peso ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Presentación</dt>
                    <dd class="text-gray-800">{{ $orden->presentacion ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Costal</dt>
                    <dd class="text-gray-800">{{ $orden->costal ?: '---' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="font-semibold text-gray-600">Producto</dt>
                    <dd class="text-gray-800">{{ $orden->producto ?: '---' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="font-semibold text-gray-600">Observaciones</dt>
                    <dd class="text-gray-800">{{ $orden->observaciones ?: '---' }}</dd>
                </div>
            </dl>
        </div>

        <div class="bg-white shadow-sm rounded-lg p-6 space-y-3">
            <h3 class="text-sm font-semibold text-gray-700 uppercase">Datos del operador</h3>
            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-2 text-sm">
                <div>
                    <dt class="font-semibold text-gray-600">Nombre</dt>
                    <dd class="text-gray-800">{{ $orden->operador_nombre }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Celular</dt>
                    <dd class="text-gray-800">{{ $orden->operador_celular ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Datos licencia</dt>
                    <dd class="text-gray-800">{{ $orden->operador_licencia ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">RFC / CURP</dt>
                    <dd class="text-gray-800">{{ $orden->operador_curp ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Placas camión</dt>
                    <dd class="text-gray-800">{{ $orden->placas_camion ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Descripción</dt>
                    <dd class="text-gray-800">{{ $orden->descripcion ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Línea</dt>
                    <dd class="text-gray-800">{{ $orden->linea ?: '---' }}</dd>
                </div>
                <div>
                    <dt class="font-semibold text-gray-600">Póliza</dt>
                    <dd class="text-gray-800">{{ $orden->poliza ?: '---' }}</dd>
                </div>
                <div class="sm:col-span-2">
                    <dt class="font-semibold text-gray-600">Referencia</dt>
                    <dd class="text-gray-800">{{ $orden->referencia ?: '---' }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <div class="bg-white shadow-sm rounded-lg p-6 mt-6">
        <h3 class="text-sm font-semibold text-gray-700 uppercase mb-3">Firmas</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
            <div class="space-y-2">
                <p class="font-semibold text-gray-600 uppercase">Elaboró</p>
                <p class="text-gray-800">{{ $orden->elaboro_nombre }}</p>
                <p class="text-gray-600">Celular: {{ $orden->elaboro_celular ?: '---' }}</p>
            </div>
            <div class="space-y-2">
                <p class="font-semibold text-gray-600 uppercase">Recibe</p>
                <p class="text-gray-800">{{ $orden->recibe_nombre ?: '---' }}</p>
                <p class="text-gray-600">Celular: {{ $orden->recibe_celular ?: '---' }}</p>
            </div>
        </div>
    </div>
</x-app-layout>


