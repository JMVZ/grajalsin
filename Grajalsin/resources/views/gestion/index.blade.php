<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Gestión</h2>
    </x-slot>

    <h3 class="text-lg font-semibold text-gray-700 mb-3">Catálogos</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <a href="{{ route('choferes.index') }}" class="block rounded-lg border border-green-200 p-5 hover:shadow-md transition">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center text-green-700">🚚</div>
                <div>
                    <p class="text-sm text-green-700 font-semibold">Catálogos</p>
                    <h3 class="text-lg font-bold text-gray-800">Choferes</h3>
                    <p class="text-sm text-gray-500">Altas, ediciones y bajas de choferes</p>
                </div>
            </div>
        </a>

        <a href="{{ route('users.index') }}" class="block rounded-lg border border-green-200 p-5 hover:shadow-md transition">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center text-green-700">👤</div>
                <div>
                    <p class="text-sm text-green-700 font-semibold">Catálogos</p>
                    <h3 class="text-lg font-bold text-gray-800">Usuarios</h3>
                    <p class="text-sm text-gray-500">Gestión de usuarios y roles</p>
                </div>
            </div>
        </a>

        <a href="{{ route('bodegas.index') }}" class="block rounded-lg border border-green-200 p-5 hover:shadow-md transition">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center text-green-700">🏬</div>
                <div>
                    <p class="text-sm text-green-700 font-semibold">Catálogos</p>
                    <h3 class="text-lg font-bold text-gray-800">Bodegas</h3>
                    <p class="text-sm text-gray-500">Bodegas de carga y su ubicación</p>
                </div>
            </div>
        </a>

        <a href="{{ route('lineas-carga.index') }}" class="block rounded-lg border border-green-200 p-5 hover:shadow-md transition">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center text-green-700">🚛</div>
                <div>
                    <p class="text-sm text-green-700 font-semibold">Catálogos</p>
                    <h3 class="text-lg font-bold text-gray-800">Líneas de Carga</h3>
                    <p class="text-sm text-gray-500">Transportistas y líneas de carga</p>
                </div>
            </div>
        </a>

        <a href="{{ route('clientes.index') }}" class="block rounded-lg border border-green-200 p-5 hover:shadow-md transition">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center text-green-700">👥</div>
                <div>
                    <p class="text-sm text-green-700 font-semibold">Catálogos</p>
                    <h3 class="text-lg font-bold text-gray-800">Clientes</h3>
                    <p class="text-sm text-gray-500">Catálogo de clientes</p>
                </div>
            </div>
        </a>

        <a href="{{ route('destinos.index') }}" class="block rounded-lg border border-green-200 p-5 hover:shadow-md transition">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center text-green-700">📍</div>
                <div>
                    <p class="text-sm text-green-700 font-semibold">Catálogos</p>
                    <h3 class="text-lg font-bold text-gray-800">Destinos</h3>
                    <p class="text-sm text-gray-500">Destinos de carga</p>
                </div>
            </div>
        </a>

        <a href="{{ route('proveedores.index') }}" class="block rounded-lg border border-green-200 p-5 hover:shadow-md transition">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded bg-green-100 flex items-center justify-center text-green-700">📦</div>
                <div>
                    <p class="text-sm text-green-700 font-semibold">Catálogos</p>
                    <h3 class="text-lg font-bold text-gray-800">Proveedores</h3>
                    <p class="text-sm text-gray-500">Proveedores para órdenes de compra</p>
                </div>
            </div>
        </a>
    </div>
</x-app-layout>


