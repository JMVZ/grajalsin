@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium text-gray-700">Nombre / Razón Social</label>
        <input type="text" name="nombre" value="{{ old('nombre', $proveedor->nombre ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500" required>
        @error('nombre')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">RFC</label>
        <input type="text" name="rfc" value="{{ old('rfc', $proveedor->rfc ?? '') }}" maxlength="13" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        @error('rfc')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Persona de contacto</label>
        <input type="text" name="contacto" value="{{ old('contacto', $proveedor->contacto ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        @error('contacto')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Celular</label>
        <input type="text" name="celular" value="{{ old('celular', $proveedor->celular ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        @error('celular')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
        <input type="text" name="telefono" value="{{ old('telefono', $proveedor->telefono ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        @error('telefono')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div>
        <label class="block text-sm font-medium text-gray-700">Email</label>
        <input type="email" name="email" value="{{ old('email', $proveedor->email ?? '') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
        @error('email')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center space-x-2">
        <input type="checkbox" name="estatus" value="1" class="rounded border-gray-300 text-green-600 focus:ring-green-500" {{ old('estatus', $proveedor->estatus ?? true) ? 'checked' : '' }}>
        <span class="text-sm text-gray-700">Activo</span>
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Dirección</label>
        <textarea name="direccion" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('direccion', $proveedor->direccion ?? '') }}</textarea>
        @error('direccion')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>

    <div class="md:col-span-2">
        <label class="block text-sm font-medium text-gray-700">Notas</label>
        <textarea name="notas" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('notas', $proveedor->notas ?? '') }}</textarea>
        @error('notas')<p class="text-sm text-red-600">{{ $message }}</p>@enderror
    </div>
</div>

<div class="mt-6 flex justify-end space-x-2">
    <a href="{{ route('proveedores.index') }}" class="px-4 py-2 rounded-md border border-gray-300 text-gray-700 hover:bg-gray-50">Cancelar</a>
    <button type="submit" class="px-4 py-2 rounded-md bg-green-600 text-white hover:bg-green-700">Guardar</button>
</div>
