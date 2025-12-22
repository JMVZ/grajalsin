@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre del destino</label>
        <input type="text" name="nombre" value="{{ old('nombre', $destino->nombre ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required placeholder="Ej: MORELIA">
        @error('nombre')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center space-x-2">
        <input type="checkbox" name="estatus" value="1" class="rounded border-gray-300 text-green-600 focus:ring-green-500" {{ old('estatus', ($destino->estatus ?? true)) ? 'checked' : '' }}>
        <span class="text-sm text-gray-700">Activo</span>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Notas</label>
        <textarea name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notas', $destino->notas ?? '') }}</textarea>
        @error('notas')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex justify-end space-x-2">
    <a href="{{ route('destinos.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
    <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Guardar</button>
</div>

