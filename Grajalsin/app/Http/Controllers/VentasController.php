<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\PedidoVenta;

class VentasController extends Controller
{
    public function index()
    {
        $pedidosRecientes = PedidoVenta::with(['cliente', 'bodega', 'destino', 'producto'])
            ->orderByDesc('fecha')
            ->take(10)
            ->get();

        $totalClientes = Cliente::where('estatus', true)->count();
        $pedidosMes = PedidoVenta::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->count();
        $totalPedidosMes = PedidoVenta::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->get()
            ->sum(fn ($p) => $p->importe_total);

        return view('ventas.index', [
            'pedidosRecientes' => $pedidosRecientes,
            'totalClientes' => $totalClientes,
            'pedidosMes' => $pedidosMes,
            'totalPedidosMes' => $totalPedidosMes,
        ]);
    }
}
