<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar chofer
        </h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('choferes.update', $chofer) }}">
            @method('PUT')
            @include('choferes.form', ['chofer' => $chofer])
        </form>
    </div>
</x-app-layout>


