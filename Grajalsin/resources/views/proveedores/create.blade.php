<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo Proveedor</h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('proveedores.store') }}">
            @include('proveedores.form', ['proveedor' => new \App\Models\Proveedor])
        </form>
    </div>
</x-app-layout>
