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
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
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
    // Catálogo de proveedores (CRUD básico)
    Route::resource('proveedores', \App\Http\Controllers\ProveedorController::class)->parameters(['proveedores' => 'proveedor'])->except(['show']);
    // Hub de Operaciones de Carga
    Route::get('operaciones', [\App\Http\Controllers\OperacionesController::class, 'index'])->name('operaciones.index');
    // Módulo de Pre-órdenes de Carga
    Route::get('pre-ordenes/{preOrden}/impresion', [PreOrdenController::class, 'print'])->name('pre-ordenes.print');
    Route::resource('pre-ordenes', PreOrdenController::class)->parameters(['pre-ordenes' => 'preOrden']);

    Route::get('ordenes-carga/{ordenes_carga}/impresion', [\App\Http\Controllers\OrdenCargaController::class, 'print'])->name('ordenes-carga.print');
    Route::resource('ordenes-carga', \App\Http\Controllers\OrdenCargaController::class)->parameters(['ordenes-carga' => 'ordenes_carga'])->except(['edit', 'update']);

    Route::get('boletas-salida/{boletas_salida}/impresion', [BoletaSalidaController::class, 'print'])->name('boletas-salida.print');
    Route::resource('boletas-salida', BoletaSalidaController::class)->parameters(['boletas-salida' => 'boletas_salida'])->except(['edit', 'update']);

    // Módulo de Ventas
    Route::get('ventas', [\App\Http\Controllers\VentasController::class, 'index'])->name('ventas.index');
    Route::get('ventas/pedidos', [\App\Http\Controllers\PedidoVentaController::class, 'index'])->name('ventas.pedidos.index');
    Route::get('ventas/pedidos/crear', [\App\Http\Controllers\PedidoVentaController::class, 'create'])->name('ventas.pedidos.create');
    Route::post('ventas/pedidos', [\App\Http\Controllers\PedidoVentaController::class, 'store'])->name('ventas.pedidos.store');
    Route::get('ventas/pedidos/{pedidoVenta}', [\App\Http\Controllers\PedidoVentaController::class, 'show'])->name('ventas.pedidos.show');
    Route::get('ventas/pedidos/{pedidoVenta}/impresion', [\App\Http\Controllers\PedidoVentaController::class, 'print'])->name('ventas.pedidos.print');
    Route::get('ventas/pedidos/{pedidoVenta}/editar', [\App\Http\Controllers\PedidoVentaController::class, 'edit'])->name('ventas.pedidos.edit');
    Route::put('ventas/pedidos/{pedidoVenta}', [\App\Http\Controllers\PedidoVentaController::class, 'update'])->name('ventas.pedidos.update');
    Route::delete('ventas/pedidos/{pedidoVenta}', [\App\Http\Controllers\PedidoVentaController::class, 'destroy'])->name('ventas.pedidos.destroy');
    Route::post('ventas/pedidos/{pedidoVenta}/estatus', [\App\Http\Controllers\PedidoVentaController::class, 'cambiarEstatus'])->name('ventas.pedidos.estatus');

    // Cobranza (estado de cuenta clientes)
    Route::get('cobranza', [\App\Http\Controllers\CobranzaController::class, 'index'])->name('cobranza.index');
    Route::get('cobranza/{cliente}', [\App\Http\Controllers\CobranzaController::class, 'show'])->name('cobranza.show');
    Route::get('cobranza/{cliente}/pago', [\App\Http\Controllers\CobranzaController::class, 'createPago'])->name('cobranza.pago.create');
    Route::post('cobranza/{cliente}/pago', [\App\Http\Controllers\CobranzaController::class, 'storePago'])->name('cobranza.pago.store');

    // Módulo de Compras
    Route::get('compras', [\App\Http\Controllers\ComprasController::class, 'index'])->name('compras.index');
    Route::get('compras/ordenes', [\App\Http\Controllers\OrdenCompraController::class, 'index'])->name('compras.ordenes.index');
    Route::get('compras/ordenes/crear', [\App\Http\Controllers\OrdenCompraController::class, 'create'])->name('compras.ordenes.create');
    Route::post('compras/ordenes', [\App\Http\Controllers\OrdenCompraController::class, 'store'])->name('compras.ordenes.store');
    Route::get('compras/ordenes/{ordenCompra}', [\App\Http\Controllers\OrdenCompraController::class, 'show'])->name('compras.ordenes.show');
    Route::get('compras/ordenes/{ordenCompra}/impresion', [\App\Http\Controllers\OrdenCompraController::class, 'print'])->name('compras.ordenes.print');
    Route::get('compras/ordenes/{ordenCompra}/editar', [\App\Http\Controllers\OrdenCompraController::class, 'edit'])->name('compras.ordenes.edit');
    Route::put('compras/ordenes/{ordenCompra}', [\App\Http\Controllers\OrdenCompraController::class, 'update'])->name('compras.ordenes.update');
    Route::delete('compras/ordenes/{ordenCompra}', [\App\Http\Controllers\OrdenCompraController::class, 'destroy'])->name('compras.ordenes.destroy');
    Route::post('compras/ordenes/{ordenCompra}/estatus', [\App\Http\Controllers\OrdenCompraController::class, 'cambiarEstatus'])->name('compras.ordenes.estatus');

    // Cuentas por pagar (estado de cuenta proveedores)
    Route::get('cuentas-pagar', [\App\Http\Controllers\CuentasPagarController::class, 'index'])->name('cuentas-pagar.index');
    Route::get('cuentas-pagar/{proveedor}', [\App\Http\Controllers\CuentasPagarController::class, 'show'])->name('cuentas-pagar.show');
    Route::get('cuentas-pagar/{proveedor}/pago', [\App\Http\Controllers\CuentasPagarController::class, 'createPago'])->name('cuentas-pagar.pago.create');
    Route::post('cuentas-pagar/{proveedor}/pago', [\App\Http\Controllers\CuentasPagarController::class, 'storePago'])->name('cuentas-pagar.pago.store');

    // Servicios de Logística CATTA
    Route::get('servicio-logistica/{servicioLogistica}/impresion', [\App\Http\Controllers\ServicioLogisticaController::class, 'print'])->name('servicio-logistica.print');
    Route::get('servicio-logistica/{servicioLogistica}/paso2', [\App\Http\Controllers\ServicioLogisticaController::class, 'paso2'])->name('servicio-logistica.paso2');
    Route::post('servicio-logistica/{servicioLogistica}/paso2', [\App\Http\Controllers\ServicioLogisticaController::class, 'guardarPaso2'])->name('servicio-logistica.guardar-paso2');
    Route::get('servicio-logistica/{servicioLogistica}/paso3', [\App\Http\Controllers\ServicioLogisticaController::class, 'paso3'])->name('servicio-logistica.paso3');
    Route::post('servicio-logistica/{servicioLogistica}/paso3', [\App\Http\Controllers\ServicioLogisticaController::class, 'guardarPaso3'])->name('servicio-logistica.guardar-paso3');
    Route::get('servicio-logistica/{servicioLogistica}/paso4', [\App\Http\Controllers\ServicioLogisticaController::class, 'paso4'])->name('servicio-logistica.paso4');
    Route::post('servicio-logistica/{servicioLogistica}/paso4', [\App\Http\Controllers\ServicioLogisticaController::class, 'guardarPaso4'])->name('servicio-logistica.guardar-paso4');
    Route::get('servicio-logistica/{servicioLogistica}/paso5', [\App\Http\Controllers\ServicioLogisticaController::class, 'paso5'])->name('servicio-logistica.paso5');
    Route::post('servicio-logistica/{servicioLogistica}/paso5', [\App\Http\Controllers\ServicioLogisticaController::class, 'guardarPaso5'])->name('servicio-logistica.guardar-paso5');
    Route::resource('servicio-logistica', \App\Http\Controllers\ServicioLogisticaController::class)->parameters(['servicio-logistica' => 'servicioLogistica']);
});

require __DIR__.'/auth.php';
