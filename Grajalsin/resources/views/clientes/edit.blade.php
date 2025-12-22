<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Cliente
        </h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('clientes.update', $cliente) }}">
            @method('PUT')
            @include('clientes.form', ['cliente' => $cliente])
        </form>
    </div>
</x-app-layout>








