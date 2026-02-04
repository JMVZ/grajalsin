<?php

namespace App\Http\Controllers;

use App\Models\OrdenCompra;
use App\Models\Proveedor;

class ComprasController extends Controller
{
    public function index()
    {
        $ordenesRecientes = OrdenCompra::with('proveedor')
            ->orderByDesc('fecha')
            ->take(10)
            ->get();

        $totalProveedores = Proveedor::activos()->count();
        $ordenesMes = OrdenCompra::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->count();
        $totalOrdenesMes = OrdenCompra::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->sum('total');

        return view('compras.index', [
            'ordenesRecientes' => $ordenesRecientes,
            'totalProveedores' => $totalProveedores,
            'ordenesMes' => $ordenesMes,
            'totalOrdenesMes' => $totalOrdenesMes,
        ]);
    }
}
