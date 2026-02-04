@props([
    'route' => null,
    'placeholder' => 'Buscar...',
    'search' => request('search'),
    'perPage' => request('per_page', 15),
    'total' => 0,
])

@php
    $baseUrl = $route ? route($route) : url()->current();
    $perPageOptions = [10, 15, 25, 50, 100];
@endphp

<div class="flex flex-col sm:flex-row gap-4 p-4 bg-white border-b border-gray-200 rounded-t-lg">
    <form method="GET" action="{{ $baseUrl }}" class="flex flex-1 gap-2">
        @if(request('per_page'))
            <input type="hidden" name="per_page" value="{{ request('per_page') }}">
        @endif
        <div class="relative flex-1">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <input type="text" name="search" value="{{ $search }}"
                placeholder="{{ $placeholder }}"
                class="block w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
        </div>
        <button type="submit" class="px-4 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            Buscar
        </button>
        @if($search)
            <a href="{{ $baseUrl . (request('per_page') ? '?per_page=' . request('per_page') : '') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 hover:bg-gray-50 transition-colors flex items-center">
                Limpiar
            </a>
        @endif
    </form>
    <form method="GET" action="{{ $baseUrl }}" class="flex items-center gap-2" id="per-page-form">
        @if(request('search'))
            <input type="hidden" name="search" value="{{ request('search') }}">
        @endif
        <label for="per_page" class="text-sm font-medium text-gray-700 whitespace-nowrap">Mostrar:</label>
        <select name="per_page" id="per_page" onchange="this.form.submit()"
            class="block py-2.5 pl-3 pr-8 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
            @foreach($perPageOptions as $opt)
                <option value="{{ $opt }}" {{ (int) $perPage === $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>
        <span class="text-sm text-gray-500">por página</span>
    </form>
</div>
