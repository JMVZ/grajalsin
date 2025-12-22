<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $inicioMes = $now->copy()->startOfMonth();
        $inicioMesAnterior = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $finMesAnterior = $now->copy()->subMonthNoOverflow()->endOfMonth();

        $productosConStock = Producto::manejaStock()->get();

        $totalInventario = (float) $productosConStock->sum('stock_actual');
        $valorInventario = (float) $productosConStock->sum(function (Producto $producto) {
            return $producto->valor_inventario;
        });

        $inventarioPorProducto = $productosConStock
            ->sortByDesc('stock_actual')
            ->take(6);

        $entradasMesCantidad = (float) Movimiento::where('tipo', 'entrada')
            ->whereBetween('fecha_movimiento', [$inicioMes, $now])
            ->sum('cantidad');

        $salidasMesCantidad = (float) Movimiento::where('tipo', 'salida')
            ->whereBetween('fecha_movimiento', [$inicioMes, $now])
            ->sum('cantidad');

        $ventasMes = $this->sumMovimientosMonetarios(
            Movimiento::where('tipo', 'salida')
                ->where('motivo', 'venta')
                ->whereBetween('fecha_movimiento', [$inicioMes, $now])
                ->get()
        );

        $ventasMesAnterior = $this->sumMovimientosMonetarios(
            Movimiento::where('tipo', 'salida')
                ->where('motivo', 'venta')
                ->whereBetween('fecha_movimiento', [$inicioMesAnterior, $finMesAnterior])
                ->get()
        );

        $comprasMes = $this->sumMovimientosMonetarios(
            Movimiento::where('tipo', 'entrada')
                ->where('motivo', 'compra')
                ->whereBetween('fecha_movimiento', [$inicioMes, $now])
                ->get()
        );

        $comprasMesAnterior = $this->sumMovimientosMonetarios(
            Movimiento::where('tipo', 'entrada')
                ->where('motivo', 'compra')
                ->whereBetween('fecha_movimiento', [$inicioMesAnterior, $finMesAnterior])
                ->get()
        );

        $gananciaNeta = $ventasMes - $comprasMes;

        $movimientosRecientes = Movimiento::with(['producto'])
            ->orderByDesc('fecha_movimiento')
            ->take(10)
            ->get();

        return view('dashboard', [
            'fechaActual' => $now,
            'totalInventario' => $totalInventario,
            'valorInventario' => $valorInventario,
            'entradasMesCantidad' => $entradasMesCantidad,
            'salidasMesCantidad' => $salidasMesCantidad,
            'ventasMes' => $ventasMes,
            'ventasMesAnterior' => $ventasMesAnterior,
            'comprasMes' => $comprasMes,
            'comprasMesAnterior' => $comprasMesAnterior,
            'gananciaNeta' => $gananciaNeta,
            'movimientosRecientes' => $movimientosRecientes,
            'inventarioPorProducto' => $inventarioPorProducto,
        ]);
    }

    private function sumMovimientosMonetarios($movimientos): float
    {
        return (float) $movimientos->sum(function (Movimiento $movimiento) {
            if (!is_null($movimiento->total)) {
                return (float) $movimiento->total;
            }

            if (!is_null($movimiento->precio_unitario)) {
                return (float) $movimiento->cantidad * (float) $movimiento->precio_unitario;
            }

            return 0;
        });
    }
}


