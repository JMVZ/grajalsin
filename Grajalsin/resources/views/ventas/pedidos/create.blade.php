<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo Pedido de Venta</h2>
    </x-slot>

    <div class="bg-white shadow-sm rounded-lg p-6">
        <form method="POST" action="{{ route('ventas.pedidos.store') }}">
            @include('ventas.pedidos.form', ['pedidoVenta' => null, 'clientes' => $clientes, 'bodegas' => $bodegas, 'destinos' => $destinos, 'productos' => $productos])
        </form>
    </div>
</x-app-layout>
