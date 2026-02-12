<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\MovimientoCuentaProveedor;
use App\Models\OrdenCompra;
use App\Models\OrdenCompraLinea;
use App\Models\Proveedor;
use App\Models\Producto;
use Illuminate\Http\Request;

class OrdenCompraController extends Controller
{
    public function index()
    {
        $query = OrdenCompra::with('proveedor')->orderByDesc('fecha');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                    ->orWhereHas('proveedor', fn($p) => $p->where('nombre', 'like', "%{$search}%"));
            });
        }
        if ($tipo = request('tipo')) {
            $query->where('tipo', $tipo);
        }
        $ordenes = $query->paginate(request('per_page', 15))->withQueryString();
        return view('compras.ordenes.index', compact('ordenes'));
    }

    public function create()
    {
        $proveedores = Proveedor::activos()->orderBy('nombre')->get();
        // Los productos se filtrarán por JavaScript según el tipo seleccionado
        $productos = Producto::activos()->orderBy('nombre')->get();
        return view('compras.ordenes.create', compact('proveedores', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipo' => ['required', 'in:insumos,granos'],
            'fecha' => ['required', 'date'],
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'forma_pago' => ['nullable', 'string', 'max:100'],
            'tipo_compra' => ['nullable', 'string', 'in:contado,credito'],
            'uso_cfdi' => ['nullable', 'string', 'max:100'],
            'elaborado_por' => ['nullable', 'string', 'max:100'],
            'solicitado_por' => ['nullable', 'string', 'max:100'],
            'notas' => ['nullable', 'string'],
            'lineas' => ['required', 'array', 'min:1'],
            'lineas.*.descripcion' => ['required', 'string'],
            'lineas.*.cantidad' => ['required', 'numeric', 'min:0.01'],
            'lineas.*.unidad' => ['nullable', 'string', 'max:50'],
            'lineas.*.producto_id' => ['nullable', 'exists:productos,id'],
        ]);

        $orden = OrdenCompra::create([
            'tipo' => $validated['tipo'],
            'folio' => OrdenCompra::generarFolio($validated['tipo']),
            'fecha' => $validated['fecha'],
            'proveedor_id' => $validated['proveedor_id'],
            'forma_pago' => $validated['forma_pago'] ?? null,
            'tipo_compra' => $validated['tipo_compra'] ?? 'contado',
            'uso_cfdi' => $validated['uso_cfdi'] ?? null,
            'elaborado_por' => $validated['elaborado_por'] ?? null,
            'solicitado_por' => $validated['solicitado_por'] ?? null,
            'notas' => $validated['notas'] ?? null,
            'estatus' => 'borrador',
            'user_id' => auth()->id(),
        ]);

        foreach ($validated['lineas'] as $i => $linea) {
            OrdenCompraLinea::create([
                'orden_compra_id' => $orden->id,
                'producto_id' => $linea['producto_id'] ?? null,
                'descripcion' => $linea['descripcion'],
                'cantidad' => $linea['cantidad'],
                'unidad' => $linea['unidad'] ?? 'pza',
                'piezas' => null,
                'precio_unitario' => 0,
                'orden' => $i,
            ]);
        }

        $orden->recalcularTotales();
        $orden->load('lineas');

        if (($validated['tipo_compra'] ?? 'contado') === 'credito') {
            $monto = (float) $orden->lineas->sum('importe');
            if ($monto > 0) {
                MovimientoCuentaProveedor::create([
                    'proveedor_id' => $orden->proveedor_id,
                    'fecha' => $orden->fecha,
                    'tipo' => 'cargo',
                    'concepto' => 'compra',
                    'monto' => $monto,
                    'referencia_tipo' => OrdenCompra::class,
                    'referencia_id' => $orden->id,
                    'notas' => 'Orden ' . $orden->folio,
                    'user_id' => auth()->id(),
                ]);
            }
        }

        // Insumos y granos afectan inventario al crear la orden
        $movimientosCreados = 0;
        $orden->load('lineas.producto');
        foreach ($orden->lineas as $linea) {
            if ($linea->producto_id && $linea->producto) {
                Movimiento::create([
                    'producto_id' => $linea->producto_id,
                    'tipo' => 'entrada',
                    'motivo' => 'compra',
                    'cantidad' => $linea->cantidad,
                    'precio_unitario' => 0,
                    'total' => 0,
                    'referencia' => $orden->folio,
                    'notas' => "Orden de compra {$orden->folio}",
                    'user_id' => auth()->id(),
                    'fecha_movimiento' => $orden->fecha,
                ]);
                $movimientosCreados++;
            }
        }

        $mensaje = 'Orden de compra creada correctamente';
        if ($movimientosCreados > 0) {
            $mensaje .= ". Se registraron {$movimientosCreados} entradas en inventario.";
        } elseif ($orden->lineas->isNotEmpty()) {
            $mensaje .= '. No se afectó inventario (ninguna línea tiene producto vinculado).';
        }

        return redirect()->route('compras.ordenes.show', $orden)
            ->with('success', $mensaje);
    }

    public function show(OrdenCompra $ordenCompra)
    {
        $ordenCompra->load(['proveedor', 'lineas.producto']);
        return view('compras.ordenes.show', compact('ordenCompra'));
    }

    public function print(OrdenCompra $ordenCompra)
    {
        $ordenCompra->load(['proveedor', 'lineas.producto']);
        // Por ahora ambos tipos (insumos y granos) usan el mismo formato
        return view('compras.ordenes.print', compact('ordenCompra'));
    }

    public function edit(OrdenCompra $ordenCompra)
    {
        if ($ordenCompra->estatus === 'cancelada') {
            return redirect()->route('compras.ordenes.show', $ordenCompra)
                ->with('error', 'No se pueden editar órdenes canceladas');
        }
        $ordenCompra->load('lineas');
        $proveedores = Proveedor::activos()->orderBy('nombre')->get();
        // Los productos se filtrarán por JavaScript según el tipo
        $productos = Producto::activos()->orderBy('nombre')->get();
        return view('compras.ordenes.edit', compact('ordenCompra', 'proveedores', 'productos'));
    }

    public function update(Request $request, OrdenCompra $ordenCompra)
    {
        if ($ordenCompra->estatus === 'cancelada') {
            return redirect()->route('compras.ordenes.show', $ordenCompra)
                ->with('error', 'No se pueden editar órdenes canceladas');
        }

        $validated = $request->validate([
            'fecha' => ['required', 'date'],
            'proveedor_id' => ['required', 'exists:proveedores,id'],
            'forma_pago' => ['nullable', 'string', 'max:100'],
            'tipo_compra' => ['nullable', 'string', 'in:contado,credito'],
            'uso_cfdi' => ['nullable', 'string', 'max:100'],
            'elaborado_por' => ['nullable', 'string', 'max:100'],
            'solicitado_por' => ['nullable', 'string', 'max:100'],
            'notas' => ['nullable', 'string'],
            'lineas' => ['required', 'array', 'min:1'],
            'lineas.*.descripcion' => ['required', 'string'],
            'lineas.*.cantidad' => ['required', 'numeric', 'min:0.01'],
            'lineas.*.unidad' => ['nullable', 'string', 'max:50'],
            'lineas.*.producto_id' => ['nullable', 'exists:productos,id'],
        ]);

        $tipoCompra = $validated['tipo_compra'] ?? 'contado';
        $movimientoExistente = MovimientoCuentaProveedor::where('referencia_tipo', OrdenCompra::class)
            ->where('referencia_id', $ordenCompra->id)
            ->first();

        $ordenCompra->update([
            'fecha' => $validated['fecha'],
            'proveedor_id' => $validated['proveedor_id'],
            'forma_pago' => $validated['forma_pago'] ?? null,
            'tipo_compra' => $tipoCompra,
            'uso_cfdi' => $validated['uso_cfdi'] ?? null,
            'elaborado_por' => $validated['elaborado_por'] ?? null,
            'solicitado_por' => $validated['solicitado_por'] ?? null,
            'notas' => $validated['notas'] ?? null,
        ]);

        $ordenCompra->lineas()->delete();

        foreach ($validated['lineas'] as $i => $linea) {
            OrdenCompraLinea::create([
                'orden_compra_id' => $ordenCompra->id,
                'producto_id' => $linea['producto_id'] ?? null,
                'descripcion' => $linea['descripcion'],
                'cantidad' => $linea['cantidad'],
                'unidad' => $linea['unidad'] ?? 'pza',
                'piezas' => null,
                'precio_unitario' => 0,
                'orden' => $i,
            ]);
        }

        $ordenCompra->recalcularTotales();
        $ordenCompra->load('lineas');
        $montoOrden = (float) $ordenCompra->lineas->sum('importe');

        if ($tipoCompra === 'credito') {
            if ($movimientoExistente) {
                $movimientoExistente->update([
                    'fecha' => $ordenCompra->fecha,
                    'monto' => $montoOrden,
                    'proveedor_id' => $ordenCompra->proveedor_id,
                ]);
            } elseif ($montoOrden > 0) {
                MovimientoCuentaProveedor::create([
                    'proveedor_id' => $ordenCompra->proveedor_id,
                    'fecha' => $ordenCompra->fecha,
                    'tipo' => 'cargo',
                    'concepto' => 'compra',
                    'monto' => $montoOrden,
                    'referencia_tipo' => OrdenCompra::class,
                    'referencia_id' => $ordenCompra->id,
                    'notas' => 'Orden ' . $ordenCompra->folio,
                    'user_id' => auth()->id(),
                ]);
            }
        } elseif ($movimientoExistente) {
            $movimientoExistente->delete();
        }

        return redirect()->route('compras.ordenes.show', $ordenCompra)
            ->with('success', 'Orden de compra actualizada');
    }

    public function destroy(OrdenCompra $ordenCompra)
    {
        if ($ordenCompra->estatus === 'cancelada') {
            return redirect()->route('compras.ordenes.index')
                ->with('error', 'No se pueden eliminar órdenes canceladas');
        }
        
        // Si tiene movimientos de inventario (insumos o granos), revertirlos antes de eliminar
        if ($ordenCompra->estatus !== 'cancelada') {
            $movimientosEntrada = Movimiento::where('referencia', $ordenCompra->folio)
                ->where('motivo', 'compra')
                ->where('tipo', 'entrada')
                ->get();
            
            // Verificar que no existan ya movimientos de cancelación para evitar duplicados
            $yaCancelados = Movimiento::where('referencia', $ordenCompra->folio)
                ->where('motivo', 'otro')
                ->where('tipo', 'salida')
                ->where('notas', 'like', "%Cancelación orden de compra {$ordenCompra->folio}%")
                ->exists();
            
            if (!$yaCancelados) {
                foreach ($movimientosEntrada as $mov) {
                    // Crear movimiento de salida para revertir
                    Movimiento::create([
                        'producto_id' => $mov->producto_id,
                        'tipo' => 'salida',
                        'motivo' => 'otro',
                        'cantidad' => $mov->cantidad,
                        'precio_unitario' => 0,
                        'total' => 0,
                        'referencia' => $ordenCompra->folio,
                        'notas' => "Cancelación orden de compra {$ordenCompra->folio}",
                        'user_id' => auth()->id(),
                        'fecha_movimiento' => now(),
                    ]);
                }
            }
        }
        
        $ordenCompra->delete();
        return redirect()->route('compras.ordenes.index')->with('success', 'Orden de compra eliminada');
    }

    public function cambiarEstatus(OrdenCompra $ordenCompra, Request $request)
    {
        $validated = $request->validate([
            'estatus' => ['required', 'in:cancelada'],
        ]);

        if ($ordenCompra->estatus === 'cancelada') {
            return redirect()->route('compras.ordenes.show', $ordenCompra)
                ->with('error', 'La orden ya está cancelada');
        }

        // Si tiene movimientos de inventario (insumos o granos), revertirlos
        {
            $movimientosEntrada = Movimiento::where('referencia', $ordenCompra->folio)
                ->where('motivo', 'compra')
                ->where('tipo', 'entrada')
                ->get();
            
            // Verificar que no existan ya movimientos de cancelación para evitar duplicados
            $yaCancelados = Movimiento::where('referencia', $ordenCompra->folio)
                ->where('motivo', 'otro')
                ->where('tipo', 'salida')
                ->where('notas', 'like', "%Cancelación orden de compra {$ordenCompra->folio}%")
                ->exists();
            
            if (!$yaCancelados && $movimientosEntrada->isNotEmpty()) {
                foreach ($movimientosEntrada as $mov) {
                    // Crear movimiento de salida para revertir la entrada
                    Movimiento::create([
                        'producto_id' => $mov->producto_id,
                        'tipo' => 'salida',
                        'motivo' => 'otro',
                        'cantidad' => $mov->cantidad,
                        'precio_unitario' => 0,
                        'total' => 0,
                        'referencia' => $ordenCompra->folio,
                        'notas' => "Cancelación orden de compra {$ordenCompra->folio}",
                        'user_id' => auth()->id(),
                        'fecha_movimiento' => now(),
                    ]);
                }
            }
        }

        $ordenCompra->update(['estatus' => 'cancelada']);
        return redirect()->route('compras.ordenes.show', $ordenCompra)
            ->with('success', 'Orden cancelada correctamente');
    }
}
