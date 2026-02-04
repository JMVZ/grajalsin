<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Movimiento;
use App\Models\Perdida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InventarioController extends Controller
{
    /**
     * Dashboard del inventario
     */
    public function index()
    {
        $productos = Producto::activos()->get();
        
        // Estadísticas
        $totalProductos = $productos->count();
        $productosConStock = $productos->where('maneja_stock', true)->count();
        $productosSinStock = $productos->where('maneja_stock', false)->count();
        $valorInventario = $productos->where('maneja_stock', true)->sum('valor_inventario');
        
        // Alertas
        $alertasStockBajo = $productos->filter(fn($p) => $p->isStockBajo())->count();
        
        // Movimientos recientes
        $movimientosRecientes = Movimiento::with(['producto', 'usuario'])
            ->orderBy('fecha_movimiento', 'desc')
            ->take(10)
            ->get();
        
        // Pérdidas del mes
        $perdidasMes = Perdida::whereMonth('fecha_deteccion', now()->month)
            ->whereYear('fecha_deteccion', now()->year)
            ->sum('valor_estimado');
        
        return view('inventario.index', compact(
            'productos',
            'totalProductos',
            'productosConStock',
            'productosSinStock',
            'valorInventario',
            'alertasStockBajo',
            'movimientosRecientes',
            'perdidasMes'
        ));
    }

    /**
     * Listado de productos
     */
    public function productos()
    {
        $query = Producto::query()->orderBy('nombre');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('codigo', 'like', "%{$search}%")
                    ->orWhere('descripcion', 'like', "%{$search}%");
            });
        }
        $productos = $query->paginate(request('per_page', 15))->withQueryString();
        return view('inventario.productos.index', compact('productos'));
    }

    /**
     * Crear producto
     */
    public function crearProducto()
    {
        return view('inventario.productos.create');
    }

    /**
     * Guardar producto
     */
    public function guardarProducto(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'tipo_producto' => 'required|in:costal,grano',
            'codigo' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string',
            'maneja_stock' => 'nullable',
            'stock_actual' => 'nullable|numeric|min:0',
            'stock_minimo' => 'nullable|numeric|min:0',
            'stock_maximo' => 'nullable|numeric|min:0',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'nullable|numeric|min:0',
            'ubicacion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048'
        ]);

        // Convertir maneja_stock a booleano
        $validated['maneja_stock'] = $request->has('maneja_stock') && $request->maneja_stock == '1';
        
        // Si el nombre empieza con "costal", asegurar que tipo_producto sea costal
        if (stripos($validated['nombre'], 'costal') === 0) {
            $validated['tipo_producto'] = 'costal';
        }
        
        // Si no maneja stock, asegurar que stock_actual sea 0
        if (!$validated['maneja_stock']) {
            $validated['stock_actual'] = 0;
            $validated['stock_minimo'] = null;
            $validated['stock_maximo'] = null;
        }

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Producto::create($validated);

        return redirect()->route('inventario.productos')
            ->with('success', 'Producto creado exitosamente');
    }

    /**
     * Editar producto
     */
    public function editarProducto(Producto $producto)
    {
        return view('inventario.productos.edit', compact('producto'));
    }

    /**
     * Actualizar producto
     */
    public function actualizarProducto(Request $request, Producto $producto)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'codigo' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'unidad_medida' => 'required|string',
            'maneja_stock' => 'nullable',
            'stock_actual' => 'nullable|numeric|min:0',
            'stock_minimo' => 'nullable|numeric|min:0',
            'stock_maximo' => 'nullable|numeric|min:0',
            'precio_compra' => 'nullable|numeric|min:0',
            'precio_venta' => 'nullable|numeric|min:0',
            'ubicacion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048'
        ]);

        // Convertir maneja_stock a booleano
        $validated['maneja_stock'] = $request->has('maneja_stock') && $request->maneja_stock == '1';
        
        // Si no maneja stock, asegurar que stock_actual sea 0
        if (!$validated['maneja_stock']) {
            $validated['stock_actual'] = 0;
            $validated['stock_minimo'] = null;
            $validated['stock_maximo'] = null;
        }

        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior
            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $producto->update($validated);

        return redirect()->route('inventario.productos')
            ->with('success', 'Producto actualizado exitosamente');
    }

    /**
     * Eliminar producto
     */
    public function eliminarProducto(Producto $producto)
    {
        $producto->delete();
        
        return redirect()->route('inventario.productos')
            ->with('success', 'Producto eliminado exitosamente');
    }

    /**
     * Movimientos
     */
    public function movimientos()
    {
        $query = Movimiento::with(['producto', 'usuario'])
            ->orderBy('fecha_movimiento', 'desc');
        if ($search = request('search')) {
            $query->whereHas('producto', fn($q) => $q->where('nombre', 'like', "%{$search}%"));
        }
        $movimientos = $query->paginate(request('per_page', 20))->withQueryString();
        return view('inventario.movimientos.index', compact('movimientos'));
    }

    /**
     * Crear movimiento
     */
    public function crearMovimiento()
    {
        $productos = Producto::activos()->orderBy('nombre')->get();
        return view('inventario.movimientos.create', compact('productos'));
    }

    /**
     * Guardar movimiento
     */
    public function guardarMovimiento(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'tipo' => 'required|in:entrada,salida',
            'motivo' => 'required|string',
            'cantidad' => 'required|numeric|min:0.01',
            'precio_unitario' => 'nullable|numeric|min:0',
            'lote' => 'nullable|string',
            'referencia' => 'nullable|string',
            'notas' => 'nullable|string',
            'ubicacion_origen' => 'nullable|string',
            'ubicacion_destino' => 'nullable|string',
        ]);

        // Calcular total
        if ($validated['precio_unitario']) {
            $validated['total'] = $validated['cantidad'] * $validated['precio_unitario'];
        }

        $validated['user_id'] = auth()->id();
        $validated['fecha_movimiento'] = now();

        Movimiento::create($validated);

        return redirect()->route('inventario.movimientos')
            ->with('success', 'Movimiento registrado exitosamente');
    }

    /**
     * Pérdidas
     */
    public function perdidas()
    {
        $query = Perdida::with(['producto', 'usuario'])
            ->orderBy('fecha_deteccion', 'desc');
        if ($search = request('search')) {
            $query->whereHas('producto', fn($q) => $q->where('nombre', 'like', "%{$search}%"));
        }
        $perdidas = $query->paginate(request('per_page', 20))->withQueryString();
        return view('inventario.perdidas.index', compact('perdidas'));
    }

    /**
     * Crear pérdida
     */
    public function crearPerdida()
    {
        $productos = Producto::activos()->orderBy('nombre')->get();
        return view('inventario.perdidas.create', compact('productos'));
    }

    /**
     * Guardar pérdida
     */
    public function guardarPerdida(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'tipo_perdida' => 'required|string',
            'ubicacion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'acciones_tomadas' => 'nullable|string',
            'valor_estimado' => 'nullable|numeric|min:0',
            'evidencia_foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('evidencia_foto')) {
            $validated['evidencia_foto'] = $request->file('evidencia_foto')->store('perdidas', 'public');
        }

        $validated['user_id'] = auth()->id();
        $validated['fecha_deteccion'] = now();

        Perdida::create($validated);

        return redirect()->route('inventario.perdidas')
            ->with('success', 'Pérdida registrada exitosamente');
    }

    /**
     * Editar pérdida
     */
    public function editarPerdida(Perdida $perdida)
    {
        $productos = Producto::activos()->orderBy('nombre')->get();
        return view('inventario.perdidas.edit', compact('perdida', 'productos'));
    }

    /**
     * Actualizar pérdida
     */
    public function actualizarPerdida(Request $request, Perdida $perdida)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'tipo_perdida' => 'required|string',
            'ubicacion' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'acciones_tomadas' => 'nullable|string',
            'valor_estimado' => 'nullable|numeric|min:0',
            'evidencia_foto' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('evidencia_foto')) {
            // Eliminar foto anterior si existe
            if ($perdida->evidencia_foto) {
                \Storage::disk('public')->delete($perdida->evidencia_foto);
            }
            $validated['evidencia_foto'] = $request->file('evidencia_foto')->store('perdidas', 'public');
        }

        $perdida->update($validated);

        return redirect()->route('inventario.perdidas')
            ->with('success', 'Pérdida actualizada exitosamente');
    }

    /**
     * Eliminar pérdida
     */
    public function eliminarPerdida(Perdida $perdida)
    {
        // Eliminar foto si existe
        if ($perdida->evidencia_foto) {
            \Storage::disk('public')->delete($perdida->evidencia_foto);
        }

        $perdida->delete();

        return redirect()->route('inventario.perdidas')
            ->with('success', 'Pérdida eliminada exitosamente');
    }

    /**
     * Reportes
     */
    public function reportes()
    {
        // Pérdidas por tipo
        $perdidasPorTipo = Perdida::selectRaw('tipo_perdida, COUNT(*) as total, SUM(valor_estimado) as valor_total')
            ->groupBy('tipo_perdida')
            ->get();
        
        // Productos con más pérdidas
        $productosMasPerdidas = Perdida::with('producto')
            ->selectRaw('producto_id, SUM(cantidad) as total_perdido, SUM(valor_estimado) as valor_total')
            ->groupBy('producto_id')
            ->orderBy('total_perdido', 'desc')
            ->take(10)
            ->get();
        
        // Movimientos del mes
        $movimientosMes = Movimiento::whereMonth('fecha_movimiento', now()->month)
            ->whereYear('fecha_movimiento', now()->year)
            ->get();
        
        $entradasMes = $movimientosMes->where('tipo', 'entrada')->sum('cantidad');
        $salidasMes = $movimientosMes->where('tipo', 'salida')->sum('cantidad');
        
        return view('inventario.reportes', compact(
            'perdidasPorTipo',
            'productosMasPerdidas',
            'entradasMes',
            'salidasMes'
        ));
    }
}

