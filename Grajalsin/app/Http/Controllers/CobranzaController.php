<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\MovimientoCuentaCliente;
use App\Models\PagoCliente;
use Illuminate\Http\Request;

class CobranzaController extends Controller
{
    /** Listado de clientes con saldo (estado de cuenta) para cobranza. */
    public function index()
    {
        $query = Cliente::where('estatus', true)->with('movimientosCuenta');

        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('codigo', 'like', "%{$search}%");
            });
        }

        $clientes = $query->orderBy('codigo')->paginate(request('per_page', 20))->withQueryString();

        return view('cobranza.index', compact('clientes'));
    }

    /** Estado de cuenta de un cliente. */
    public function show(Cliente $cliente)
    {
        $cliente->load('movimientosCuenta.usuario');
        $saldo = $cliente->saldo_cuenta;
        return view('cobranza.show', compact('cliente', 'saldo'));
    }

    /** Formulario para registrar un pago. */
    public function createPago(Cliente $cliente)
    {
        $saldo = $cliente->saldo_cuenta;
        return view('cobranza.pago', compact('cliente', 'saldo'));
    }

    /** Guardar pago y crear abono en estado de cuenta. */
    public function storePago(Request $request, Cliente $cliente)
    {
        $validated = $request->validate([
            'fecha' => ['required', 'date'],
            'monto' => ['required', 'numeric', 'min:0.01'],
            'forma_pago' => ['nullable', 'string', 'max:100'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'notas' => ['nullable', 'string'],
        ]);

        $pago = PagoCliente::create([
            'cliente_id' => $cliente->id,
            'fecha' => $validated['fecha'],
            'monto' => $validated['monto'],
            'forma_pago' => $validated['forma_pago'] ?? null,
            'referencia' => $validated['referencia'] ?? null,
            'notas' => $validated['notas'] ?? null,
            'user_id' => auth()->id(),
        ]);

        MovimientoCuentaCliente::create([
            'cliente_id' => $cliente->id,
            'fecha' => $pago->fecha,
            'tipo' => 'abono',
            'concepto' => 'pago',
            'monto' => $pago->monto,
            'referencia_tipo' => PagoCliente::class,
            'referencia_id' => $pago->id,
            'notas' => $validated['referencia'] ?? 'Pago registrado',
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('cobranza.show', $cliente)
            ->with('success', 'Pago registrado correctamente. Se aplicó al estado de cuenta.');
    }
}
