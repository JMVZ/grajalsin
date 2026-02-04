@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
        <input type="text" name="nombre" value="{{ old('nombre', $chofer->nombre ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        @error('nombre')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $chofer->telefono ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">CURP</label>
        <input type="text" name="curp" value="{{ old('curp', $chofer->curp ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Licencia - Número</label>
        <input type="text" name="licencia_numero" value="{{ old('licencia_numero', $chofer->licencia_numero ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Licencia - Tipo</label>
        <input type="text" name="licencia_tipo" value="{{ old('licencia_tipo', $chofer->licencia_tipo ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Licencia - Vence</label>
        <input type="date" name="licencia_vence" value="{{ old('licencia_vence', optional($chofer->licencia_vence ?? null)->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="estatus" value="1" class="rounded border-gray-300" {{ old('estatus', ($chofer->estatus ?? true)) ? 'checked' : '' }}>
        <span class="text-sm text-gray-700">Activo</span>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Notas</label>
        <textarea name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notas', $chofer->notas ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6 flex justify-end space-x-2">
    <a href="{{ route('choferes.index') }}" class="px-4 py-2 rounded-md border">Cancelar</a>
    <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white">Guardar</button>
    </div>


