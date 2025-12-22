<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Pre-orden de Carga
        </h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('pre-ordenes.update', $preOrden) }}">
            @method('PUT')
            @include('pre-ordenes.form')
        </form>
    </div>
</x-app-layout>








