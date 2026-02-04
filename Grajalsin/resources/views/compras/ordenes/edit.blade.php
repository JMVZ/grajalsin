<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Orden {{ $ordenCompra->folio }}</h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('compras.ordenes.update', $ordenCompra) }}">
            @method('PUT')
            @include('compras.ordenes.form', ['ordenCompra' => $ordenCompra, 'proveedores' => $proveedores, 'productos' => $productos])
        </form>
    </div>
</x-app-layout>
