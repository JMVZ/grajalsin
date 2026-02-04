@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre</label>
        <input type="text" name="nombre" value="{{ old('nombre', $bodega->nombre ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" required>
        @error('nombre')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Clave</label>
        <input type="text" name="clave" value="{{ old('clave', $bodega->clave ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300" placeholder="Ej: B-001">
    </div>
    <div>
        <label class="block text-sm font-medium text-gray-700">Ubicación</label>
        <input type="text" name="ubicacion" value="{{ old('ubicacion', $bodega->ubicacion ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300">
    </div>
    <div class="flex items-center space-x-2">
        <input type="checkbox" name="estatus" value="1" class="rounded border-gray-300" {{ old('estatus', ($bodega->estatus ?? true)) ? 'checked' : '' }}>
        <span class="text-sm text-gray-700">Activa</span>
    </div>
    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Notas</label>
        <textarea name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notas', $bodega->notas ?? '') }}</textarea>
    </div>
</div>

<div class="mt-6 flex justify-end space-x-2">
    <a href="{{ route('bodegas.index') }}" class="px-4 py-2 rounded-md border">Cancelar</a>
    <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white">Guardar</button>
</div>


