<div>
    <select wire:model="preOrdenSeleccionada"
            name="pre_orden_id"
            class="mt-1 block w-full rounded-md border-gray-300 focus:border-green-500 focus:ring-green-500"
            {{ $preOrdenesDisponibles->isEmpty() ? 'disabled' : '' }}>
        <option value="">{{ $preOrdenesDisponibles->isEmpty() ? 'No hay pre-órdenes disponibles' : 'Seleccione una pre-orden...' }}</option>
        @foreach($preOrdenesDisponibles as $po)
            <option value="{{ $po->id }}">{{ $po->folio }} - {{ $po->chofer->nombre ?? 'Sin chofer' }}</option>
        @endforeach
    </select>
</div>

