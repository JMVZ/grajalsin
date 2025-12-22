<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-bold text-2xl text-gray-900">
                    Gestión de Módulos por Rol
                </h2>
                <p class="text-sm text-gray-600 mt-1">Asigna módulos específicos a cada rol</p>
            </div>
            <div>
                <a href="{{ route('users.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Volver a Usuarios
                </a>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">
        <!-- Gestión de Módulos por Rol -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($roles as $role)
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">
                            {{ $role->name }}
                        </h3>
                        
                        <form action="{{ route('roles.modules.update', $role) }}" method="POST">
                            @csrf
                            @method('POST')
                            
                            <div class="space-y-3">
                                @foreach($modules as $module)
                                    <div class="flex items-center">
                                        <input type="checkbox" 
                                               id="module_{{ $role->id }}_{{ $module->id }}" 
                                               name="modules[]" 
                                               value="{{ $module->id }}"
                                               {{ $role->modules->contains($module->id) ? 'checked' : '' }}
                                               class="h-4 w-4 text-amber-600 focus:ring-amber-500 border-gray-300 rounded">
                                        <label for="module_{{ $role->id }}_{{ $module->id }}" class="ml-3 flex items-center">
                                            <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $module->icon }}"></path>
                                            </svg>
                                            <span class="text-sm font-medium text-gray-900">{{ $module->name }}</span>
                                            <span class="text-xs text-gray-500 ml-2">- {{ $module->description }}</span>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-6">
                                <button type="submit" class="w-full bg-amber-600 hover:bg-amber-700 text-white px-4 py-2 rounded-md text-sm font-medium transition duration-200">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Actualizar Módulos
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Resumen de Módulos -->
        <div class="bg-white shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-4">Módulos Disponibles</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($modules as $module)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex items-center mb-2">
                                <svg class="w-6 h-6 text-amber-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $module->icon }}"></path>
                                </svg>
                                <h4 class="text-sm font-medium text-gray-900">{{ $module->name }}</h4>
                            </div>
                            <p class="text-xs text-gray-500">{{ $module->description }}</p>
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    {{ $module->route ? 'Ruta: ' . $module->route : 'Sin ruta' }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
