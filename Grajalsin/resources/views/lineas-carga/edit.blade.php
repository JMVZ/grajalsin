<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Línea de Carga
        </h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('lineas-carga.update', $lineaCarga) }}">
            @method('PUT')
            @include('lineas-carga.form', ['lineaCarga' => $lineaCarga])
        </form>
    </div>
</x-app-layout>








