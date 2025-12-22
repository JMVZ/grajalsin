<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar bodega</h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('bodegas.update', $bodega) }}">
            @method('PUT')
            @include('bodegas.form', ['bodega' => $bodega])
        </form>
    </div>
</x-app-layout>


