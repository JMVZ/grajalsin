<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Grajalsin - Control de Granos') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased bg-gradient-to-br from-gray-50 via-white to-gray-50">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <div class="hidden md:flex md:w-72 md:flex-col">
                <div class="flex flex-col flex-grow pt-6 bg-gradient-to-b from-white to-gray-50 border-r border-gray-200 shadow-xl">
                    <!-- Logo -->
                    <div class="flex items-center flex-shrink-0 px-6 mb-8">
                        <a href="{{ route('dashboard') }}" class="flex items-center w-full">
                            <div class="flex-shrink-0">
                                <img src="{{ asset('grajalsin-removebg-preview.png') }}" alt="Grajalsin Logo" class="h-12 w-auto transform hover:scale-105 transition-transform duration-200">
                            </div>
                            <div class="ml-4 flex-1">
                                <h1 class="text-2xl font-bold bg-gradient-to-r from-green-600 to-emerald-600 bg-clip-text text-transparent">Grajalsin</h1>
                                <p class="text-xs text-gray-500 font-medium">Control de Granos</p>
                            </div>
                        </a>
                    </div>

                    <!-- Navigation -->
                    <div class="mt-2 flex-grow flex flex-col">
                        <nav class="flex-1 px-4 space-y-2">
                            @php
                                $accessibleModules = auth()->user()->getAccessibleModules();
                                $currentRoute = request()->route()->getName();
                            @endphp
                            
                            <!-- Dashboard - Siempre visible -->
                            <a href="{{ route('dashboard') }}" 
                               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ $currentRoute === 'dashboard' ? 'text-white bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg shadow-green-500/30' : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700' }}">
                                <svg class="mr-3 h-5 w-5 {{ $currentRoute === 'dashboard' ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Dashboard
                            </a>

                            <!-- Operaciones de Carga - Hub -->
                            @php
                                $isOperacionesActive = $currentRoute === 'operaciones.index'
                                    || strpos($currentRoute, 'pre-ordenes') === 0
                                    || strpos($currentRoute, 'ordenes-carga') === 0;
                            @endphp
                            <a href="{{ route('operaciones.index') }}" 
                               class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ $isOperacionesActive ? 'text-white bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg shadow-green-500/30' : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700' }}">
                                <svg class="mr-3 h-5 w-5 {{ $isOperacionesActive ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}" 
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                Operaciones de Carga
                            </a>
                            
                            <!-- Módulos asignados al usuario -->
                            @foreach($accessibleModules as $module)
                                @if($module->slug !== 'dashboard')
                                    @php
                                        $isActive = $currentRoute === $module->route || 
                                                   (strpos($currentRoute, $module->slug) === 0);
                                    @endphp
                                    
                                    <a href="{{ $module->route ? route($module->route) : '#' }}" 
                                       class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ $isActive ? 'text-white bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg shadow-green-500/30' : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700' }}">
                                        <svg class="mr-3 h-5 w-5 {{ $isActive ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}" 
                                             fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $module->icon }}"></path>
                                        </svg>
                                        {{ $module->name }}
                                    </a>
                                @endif
                            @endforeach
                            
                            @if(auth()->user()->hasRole('Administrador'))
                                <!-- Enlaces adicionales para administradores -->
                                <div class="border-t border-gray-200 pt-6 mt-6">
                                    <p class="px-4 text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Administración</p>
                                    <div class="space-y-2">
                                        <a href="{{ route('gestion.index') }}" 
                                           class="group flex items-center px-4 py-3 text-sm font-semibold rounded-xl transition-all duration-200 {{ strpos($currentRoute, 'gestion') === 0 ? 'text-white bg-gradient-to-r from-green-500 to-emerald-600 shadow-lg shadow-green-500/30' : 'text-gray-700 hover:bg-gradient-to-r hover:from-green-50 hover:to-emerald-50 hover:text-green-700' }}">
                                            <svg class="mr-3 h-5 w-5 {{ strpos($currentRoute, 'gestion') === 0 ? 'text-white' : 'text-gray-400 group-hover:text-green-600' }}" 
                                                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6M5 8h14M7 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-2" />
                                            </svg>
                                            Gestión
                                        </a>
                                        
                                    </div>
                                </div>
                            @endif
                        </nav>
                    </div>

                    <!-- User Profile -->
                    <div class="flex-shrink-0 flex border-t border-gray-200 p-6 bg-gradient-to-r from-gray-50 to-white">
                        <div class="flex-shrink-0 w-full group block">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center shadow-md">
                                        <span class="text-white font-bold text-sm">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                                    </div>
                                </div>
                                <div class="ml-3 flex-1 min-w-0">
                                    <p class="text-sm font-semibold text-gray-800 truncate">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <p class="text-xs text-gray-500 truncate">
                                        {{ Auth::user()->email }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main content -->
            <div class="flex flex-col w-0 flex-1 overflow-hidden">
                <!-- Top navigation -->
                <div class="relative z-10 flex-shrink-0 flex h-20 bg-white/80 backdrop-blur-lg border-b border-gray-200 shadow-sm">
                    <button class="px-4 border-r border-gray-200 text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-green-500 md:hidden transition-colors">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path>
                        </svg>
                    </button>
                    <div class="flex-1 px-6 flex justify-end items-center">
                        <div class="ml-4 flex items-center md:ml-6">
                            <!-- Profile dropdown -->
                            <div class="ml-3 relative">
                                <div class="flex items-center space-x-4">
                                    <div class="hidden sm:block text-right">
                                        <span class="text-sm font-medium text-gray-700">Bienvenido,</span>
                                        <span class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</span>
                                    </div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold shadow-md hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                                            Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Page Heading -->
            @isset($header)
                    <header class="bg-gradient-to-r from-white via-gray-50 to-white border-b border-gray-200 shadow-sm">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
                <main class="flex-1 relative overflow-y-auto focus:outline-none bg-gradient-to-br from-gray-50 via-white to-gray-50">
                    <div class="py-8">
                        <div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
                {{ $slot }}
                        </div>
                    </div>
            </main>
            </div>
        </div>

        <!-- SweetAlert2 Alerts -->
        <x-alerts />
    </body>
</html>
