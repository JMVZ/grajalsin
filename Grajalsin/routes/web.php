<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChoferController;
use App\Http\Controllers\GestionController;
use App\Http\Controllers\BodegaController;
use App\Http\Controllers\LineaCargaController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\DestinoController;
use App\Http\Controllers\PreOrdenController;
use App\Http\Controllers\BoletaSalidaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Rutas de gestión de usuarios (solo para administradores)
    Route::middleware('role:Administrador')->group(function () {
        Route::resource('users', UserManagementController::class);
        Route::get('/roles/modules', [UserManagementController::class, 'roleModules'])->name('roles.modules');
        Route::post('/roles/{role}/modules', [UserManagementController::class, 'updateRoleModules'])->name('roles.modules.update');
        
        // Rutas para gestión de módulos por usuario
        Route::get('/users/{user}/modules', [UserManagementController::class, 'userModules'])->name('users.modules');
        Route::post('/users/{user}/modules', [UserManagementController::class, 'updateUserModules'])->name('users.modules.update');

        // Gestión - hub de catálogos
        Route::get('/gestion', [GestionController::class, 'index'])->name('gestion.index');
    });
    
    // Rutas de inventario
    Route::prefix('inventario')->name('inventario.')->group(function () {
        Route::get('/', [\App\Http\Controllers\InventarioController::class, 'index'])->name('index');
        
        // Productos
        Route::get('/productos', [\App\Http\Controllers\InventarioController::class, 'productos'])->name('productos');
        Route::get('/productos/crear', [\App\Http\Controllers\InventarioController::class, 'crearProducto'])->name('productos.create');
        Route::post('/productos', [\App\Http\Controllers\InventarioController::class, 'guardarProducto'])->name('productos.store');
        Route::get('/productos/{producto}/editar', [\App\Http\Controllers\InventarioController::class, 'editarProducto'])->name('productos.edit');
        Route::put('/productos/{producto}', [\App\Http\Controllers\InventarioController::class, 'actualizarProducto'])->name('productos.update');
        Route::delete('/productos/{producto}', [\App\Http\Controllers\InventarioController::class, 'eliminarProducto'])->name('productos.destroy');
        
        // Movimientos
        Route::get('/movimientos', [\App\Http\Controllers\InventarioController::class, 'movimientos'])->name('movimientos');
        Route::get('/movimientos/crear', [\App\Http\Controllers\InventarioController::class, 'crearMovimiento'])->name('movimientos.create');
        Route::post('/movimientos', [\App\Http\Controllers\InventarioController::class, 'guardarMovimiento'])->name('movimientos.store');
        
        // Pérdidas
        Route::get('/perdidas', [\App\Http\Controllers\InventarioController::class, 'perdidas'])->name('perdidas');
        Route::get('/perdidas/crear', [\App\Http\Controllers\InventarioController::class, 'crearPerdida'])->name('perdidas.create');
        Route::post('/perdidas', [\App\Http\Controllers\InventarioController::class, 'guardarPerdida'])->name('perdidas.store');
        Route::get('/perdidas/{perdida}/editar', [\App\Http\Controllers\InventarioController::class, 'editarPerdida'])->name('perdidas.edit');
        Route::put('/perdidas/{perdida}', [\App\Http\Controllers\InventarioController::class, 'actualizarPerdida'])->name('perdidas.update');
        Route::delete('/perdidas/{perdida}', [\App\Http\Controllers\InventarioController::class, 'eliminarPerdida'])->name('perdidas.destroy');
        
        // Reportes
        Route::get('/reportes', [\App\Http\Controllers\InventarioController::class, 'reportes'])->name('reportes');
    });

    // Catálogo de choferes (CRUD básico)
    Route::resource('choferes', ChoferController::class)
        ->parameters(['choferes' => 'chofer'])
        ->except(['show']);
    // Catálogo de bodegas (CRUD básico)
    Route::resource('bodegas', BodegaController::class)->except(['show']);
    // Catálogo de líneas de carga (CRUD básico)
    Route::resource('lineas-carga', LineaCargaController::class)->except(['show'])->parameters(['lineas-carga' => 'lineaCarga']);
    // Catálogo de clientes (CRUD básico)
    Route::resource('clientes', ClienteController::class)->except(['show']);
    // Catálogo de destinos (CRUD básico)
    Route::resource('destinos', DestinoController::class)->except(['show']);
    // Hub de Operaciones de Carga
    Route::get('operaciones', [\App\Http\Controllers\OperacionesController::class, 'index'])->name('operaciones.index');
    // Módulo de Pre-órdenes de Carga
    Route::get('pre-ordenes/{preOrden}/impresion', [PreOrdenController::class, 'print'])->name('pre-ordenes.print');
    Route::resource('pre-ordenes', PreOrdenController::class)->parameters(['pre-ordenes' => 'preOrden']);

    Route::get('ordenes-carga/{ordenes_carga}/impresion', [\App\Http\Controllers\OrdenCargaController::class, 'print'])->name('ordenes-carga.print');
    Route::resource('ordenes-carga', \App\Http\Controllers\OrdenCargaController::class)->parameters(['ordenes-carga' => 'ordenes_carga'])->except(['edit', 'update']);

    Route::get('boletas-salida/{boletas_salida}/impresion', [BoletaSalidaController::class, 'print'])->name('boletas-salida.print');
    Route::resource('boletas-salida', BoletaSalidaController::class)->parameters(['boletas-salida' => 'boletas_salida'])->except(['edit', 'update']);
});

require __DIR__.'/auth.php';
