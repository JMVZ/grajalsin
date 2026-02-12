<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use App\Models\Cliente;
use App\Models\Destino;
use App\Models\MovimientoCuentaCliente;
use App\Models\PedidoVenta;
use App\Models\Producto;
use Illuminate\Http\Request;

class PedidoVentaController extends Controller
{
    public function index()
    {
        $query = PedidoVenta::with(['cliente', 'bodega', 'destino', 'producto'])->orderByDesc('fecha');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                    ->orWhereHas('cliente', fn ($p) => $p->where('nombre', 'like', "%{$search}%"));
            });
        }
        $pedidos = $query->paginate(request('per_page', 15))->withQueryString();
        return view('ventas.pedidos.index', compact('pedidos'));
    }

    public function create()
    {
        $clientes = Cliente::where('estatus', true)->orderBy('codigo')->get();
        $bodegas = Bodega::where('estatus', true)->orderBy('nombre')->get();
        $destinos = Destino::where('estatus', true)->orderBy('nombre')->get();
        // Productos para tipo de costal (preferir costales; si no hay, mostrar todos)
        $productos = Producto::activos()->orderBy('nombre')->get();
        return view('ventas.pedidos.create', compact('clientes', 'bodegas', 'destinos', 'productos'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha' => ['required', 'date'],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'toneladas' => ['required', 'numeric', 'min:0.01'],
            'precio_venta' => ['required', 'numeric', 'min:0'],
            'tarifa_flete' => ['nullable', 'numeric', 'min:0'],
            'bodega_id' => ['required', 'exists:bodegas,id'],
            'destino_id' => ['required', 'exists:destinos,id'],
            'producto_id' => ['nullable', 'exists:productos,id'],
            'fecha_entrega' => ['required', 'date'],
            'forma_pago' => ['nullable', 'string', 'in:contado,credito'],
            'notas' => ['nullable', 'string'],
        ]);

        $pedido = PedidoVenta::create([
            'folio' => PedidoVenta::generarFolio(),
            'fecha' => $validated['fecha'],
            'cliente_id' => $validated['cliente_id'],
            'toneladas' => $validated['toneladas'],
            'precio_venta' => $validated['precio_venta'],
            'tarifa_flete' => $validated['tarifa_flete'] ?? 0,
            'bodega_id' => $validated['bodega_id'],
            'destino_id' => $validated['destino_id'],
            'producto_id' => $validated['producto_id'] ?? null,
            'fecha_entrega' => $validated['fecha_entrega'],
            'estatus' => 'activa',
            'forma_pago' => $validated['forma_pago'] ?? 'contado',
            'notas' => $validated['notas'] ?? null,
            'user_id' => auth()->id(),
        ]);

        if (($validated['forma_pago'] ?? 'contado') === 'credito') {
            MovimientoCuentaCliente::create([
                'cliente_id' => $pedido->cliente_id,
                'fecha' => $pedido->fecha,
                'tipo' => 'cargo',
                'concepto' => 'venta',
                'monto' => $pedido->importe_total,
                'referencia_tipo' => PedidoVenta::class,
                'referencia_id' => $pedido->id,
                'notas' => 'Pedido ' . $pedido->folio,
                'user_id' => auth()->id(),
            ]);
        }

        return redirect()->route('ventas.pedidos.show', $pedido)
            ->with('success', 'Pedido de venta creado correctamente.');
    }

    public function show(PedidoVenta $pedidoVenta)
    {
        $pedidoVenta->load(['cliente', 'bodega', 'destino', 'producto']);
        return view('ventas.pedidos.show', compact('pedidoVenta'));
    }

    public function print(PedidoVenta $pedidoVenta)
    {
        $pedidoVenta->load(['cliente', 'bodega', 'destino', 'producto']);
        return view('ventas.pedidos.print', compact('pedidoVenta'));
    }

    public function edit(PedidoVenta $pedidoVenta)
    {
        if ($pedidoVenta->estatus === 'cancelada') {
            return redirect()->route('ventas.pedidos.show', $pedidoVenta)
                ->with('error', 'No se pueden editar pedidos cancelados');
        }
        $clientes = Cliente::where('estatus', true)->orderBy('codigo')->get();
        $bodegas = Bodega::where('estatus', true)->orderBy('nombre')->get();
        $destinos = Destino::where('estatus', true)->orderBy('nombre')->get();
        // Productos para tipo de costal (preferir costales; si no hay, mostrar todos)
        $productos = Producto::activos()->orderBy('nombre')->get();
        return view('ventas.pedidos.edit', compact('pedidoVenta', 'clientes', 'bodegas', 'destinos', 'productos'));
    }

    public function update(Request $request, PedidoVenta $pedidoVenta)
    {
        if ($pedidoVenta->estatus === 'cancelada') {
            return redirect()->route('ventas.pedidos.show', $pedidoVenta)
                ->with('error', 'No se pueden editar pedidos cancelados');
        }

        $validated = $request->validate([
            'fecha' => ['required', 'date'],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'toneladas' => ['required', 'numeric', 'min:0.01'],
            'precio_venta' => ['required', 'numeric', 'min:0'],
            'tarifa_flete' => ['nullable', 'numeric', 'min:0'],
            'bodega_id' => ['required', 'exists:bodegas,id'],
            'destino_id' => ['required', 'exists:destinos,id'],
            'producto_id' => ['nullable', 'exists:productos,id'],
            'fecha_entrega' => ['required', 'date'],
            'forma_pago' => ['nullable', 'string', 'in:contado,credito'],
            'notas' => ['nullable', 'string'],
        ]);

        $formaPago = $validated['forma_pago'] ?? 'contado';
        $movimientoExistente = MovimientoCuentaCliente::where('referencia_tipo', PedidoVenta::class)
            ->where('referencia_id', $pedidoVenta->id)
            ->first();

        $pedidoVenta->update([
            'fecha' => $validated['fecha'],
            'cliente_id' => $validated['cliente_id'],
            'toneladas' => $validated['toneladas'],
            'precio_venta' => $validated['precio_venta'],
            'tarifa_flete' => $validated['tarifa_flete'] ?? 0,
            'bodega_id' => $validated['bodega_id'],
            'destino_id' => $validated['destino_id'],
            'producto_id' => $validated['producto_id'] ?? null,
            'fecha_entrega' => $validated['fecha_entrega'],
            'forma_pago' => $formaPago,
            'notas' => $validated['notas'] ?? null,
        ]);

        if ($formaPago === 'credito') {
            if ($movimientoExistente) {
                $movimientoExistente->update([
                    'fecha' => $pedidoVenta->fecha,
                    'monto' => $pedidoVenta->importe_total,
                    'cliente_id' => $pedidoVenta->cliente_id,
                ]);
            } else {
                MovimientoCuentaCliente::create([
                    'cliente_id' => $pedidoVenta->cliente_id,
                    'fecha' => $pedidoVenta->fecha,
                    'tipo' => 'cargo',
                    'concepto' => 'venta',
                    'monto' => $pedidoVenta->importe_total,
                    'referencia_tipo' => PedidoVenta::class,
                    'referencia_id' => $pedidoVenta->id,
                    'notas' => 'Pedido ' . $pedidoVenta->folio,
                    'user_id' => auth()->id(),
                ]);
            }
        } elseif ($movimientoExistente) {
            $movimientoExistente->delete();
        }

        return redirect()->route('ventas.pedidos.show', $pedidoVenta)
            ->with('success', 'Pedido de venta actualizado correctamente.');
    }

    public function destroy(PedidoVenta $pedidoVenta)
    {
        if ($pedidoVenta->estatus === 'cancelada') {
            return redirect()->route('ventas.pedidos.index')
                ->with('error', 'No se pueden eliminar pedidos cancelados');
        }
        $pedidoVenta->delete();
        return redirect()->route('ventas.pedidos.index')->with('success', 'Pedido de venta eliminado.');
    }

    public function cambiarEstatus(PedidoVenta $pedidoVenta, Request $request)
    {
        $validated = $request->validate([
            'estatus' => ['required', 'in:cancelada'],
        ]);

        if ($pedidoVenta->estatus === 'cancelada') {
            return redirect()->route('ventas.pedidos.show', $pedidoVenta)
                ->with('error', 'El pedido ya está cancelado');
        }

        $pedidoVenta->update(['estatus' => 'cancelada']);
        return redirect()->route('ventas.pedidos.show', $pedidoVenta)
            ->with('success', 'Pedido cancelado correctamente.');
    }
}
