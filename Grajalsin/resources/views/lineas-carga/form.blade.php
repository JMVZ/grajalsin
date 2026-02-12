@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre de la línea</label>
        <input type="text" name="nombre" value="{{ old('nombre', $lineaCarga->nombre ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
        @error('nombre')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Coordinador / persona de contacto</label>
        <input type="text" name="contacto" value="{{ old('contacto', $lineaCarga->contacto ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        @error('contacto')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Teléfono / contacto</label>
        <input type="text" name="telefono" value="{{ old('telefono', $lineaCarga->telefono ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" placeholder="Ej: 2221390702">
        @error('telefono')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Base de operación</label>
        <input type="text" name="base_operacion" value="{{ old('base_operacion', $lineaCarga->base_operacion ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        @error('base_operacion')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center space-x-2">
        <input type="checkbox" name="estatus" value="1" class="rounded border-gray-300 text-green-600 focus:ring-green-500" {{ old('estatus', ($lineaCarga->estatus ?? true)) ? 'checked' : '' }}>
        <span class="text-sm text-gray-700">Activo</span>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Notas</label>
        <textarea name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notas', $lineaCarga->notas ?? '') }}</textarea>
        @error('notas')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex justify-end space-x-2">
    <a href="{{ route('lineas-carga.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
    <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Guardar</button>
</div>

