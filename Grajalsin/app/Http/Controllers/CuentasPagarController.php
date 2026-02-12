<?php

namespace App\Http\Controllers;

use App\Models\MovimientoCuentaProveedor;
use App\Models\PagoProveedor;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class CuentasPagarController extends Controller
{
    /** Listado de proveedores con saldo (cuentas por pagar). */
    public function index()
    {
        $query = Proveedor::where('estatus', true)->with('movimientosCuenta');

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('rfc', 'like', "%{$search}%");
            });
        }

        $proveedores = $query->orderBy('nombre')->paginate(request('per_page', 20))->withQueryString();

        return view('cuentas-pagar.index', compact('proveedores'));
    }

    /** Estado de cuenta de un proveedor. */
    public function show(Proveedor $proveedor)
    {
        $proveedor->load('movimientosCuenta.usuario');
        $saldo = $proveedor->saldo_cuenta;
        return view('cuentas-pagar.show', compact('proveedor', 'saldo'));
    }

    /** Formulario para registrar un pago a proveedor. */
    public function createPago(Proveedor $proveedor)
    {
        $saldo = $proveedor->saldo_cuenta;
        return view('cuentas-pagar.pago', compact('proveedor', 'saldo'));
    }

    /** Guardar pago y crear abono en estado de cuenta. */
    public function storePago(Request $request, Proveedor $proveedor)
    {
        $validated = $request->validate([
            'fecha' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'forma_pago' => ['nullable', 'string', 'max:100'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'notas' => ['nullable', 'string'],
        ]);

        $pago = PagoProveedor::create([
            'proveedor_id' => $proveedor->id,
            'fecha' => $validated['fecha'],
            'monto' => $validated['monto'],
            'forma_pago' => $validated['forma_pago'] ?? null,
            'referencia' => $validated['referencia'] ?? null,
            'notas' => $validated['notas'] ?? null,
            'user_id' => auth()->id(),
        ]);

        MovimientoCuentaProveedor::create([
            'proveedor_id' => $proveedor->id,
            'fecha' => $pago->fecha,
            'tipo' => 'abono',
            'concepto' => 'pago',
            'monto' => $pago->monto,
            'referencia_tipo' => PagoProveedor::class,
            'referencia_id' => $pago->id,
            'notas' => $validated['referencia'] ?? 'Pago registrado',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('cuentas-pagar.show', $proveedor)
            ->with('success', 'Pago registrado correctamente. Se aplicó al estado de cuenta.');
    }
}
