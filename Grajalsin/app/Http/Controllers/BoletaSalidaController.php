<?php

namespace App\Http\Controllers;

use App\Models\BoletaSalida;
use App\Models\OrdenCarga;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BoletaSalidaController extends Controller
{
    public function index()
    {
        $boletas = BoletaSalida::with([
            'ordenCarga',
            'ordenCarga.preOrden.cliente',
            'ordenCarga.preOrden.destino',
        ])->orderByDesc('fecha')->paginate(15);

        return view('boletas-salida.index', compact('boletas'));
    }

    public function create(Request $request)
    {
        $ordenSeleccionada = null;

        if ($request->filled('orden')) {
            $ordenSeleccionada = OrdenCarga::with([
                'preOrden.cliente',
                'preOrden.destino',
                'preOrden.lineaCarga',
                'preOrden.chofer',
                'boletaSalida',
            ])->findOrFail($request->query('orden'));

            if ($ordenSeleccionada->boletaSalida) {
                return redirect()
                    ->route('boletas-salida.show', $ordenSeleccionada->boletaSalida)
                    ->with('info', 'La orden seleccionada ya cuenta con una boleta de salida.');
            }
        }

        $ordenesDisponibles = OrdenCarga::with('preOrden')
            ->doesntHave('boletaSalida')
            ->orderByDesc('fecha_entrada')
            ->get();

        return view('boletas-salida.create', [
            'ordenSeleccionada' => $ordenSeleccionada,
            'ordenesDisponibles' => $ordenesDisponibles,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'orden_carga_id' => ['required', 'exists:ordenes_carga,id'],
            'fecha' => ['required', 'date'],
            'cliente_tipo' => ['nullable', 'string', 'max:255'],
            'cliente_nombre' => ['required', 'string', 'max:255'],
            'cliente_rfc' => ['nullable', 'string', 'max:255'],
            'producto' => ['required', 'string', 'max:255'],
            'variedad' => ['nullable', 'string', 'max:255'],
            'cosecha' => ['nullable', 'string', 'max:255'],
            'envase' => ['nullable', 'string', 'max:255'],
            'origen' => ['nullable', 'string', 'max:255'],
            'destino' => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'operador_nombre' => ['required', 'string', 'max:255'],
            'operador_celular' => ['nullable', 'string', 'max:255'],
            'operador_licencia' => ['nullable', 'string', 'max:255'],
            'operador_curp' => ['nullable', 'string', 'max:255'],
            'camion' => ['nullable', 'string', 'max:255'],
            'placas' => ['nullable', 'string', 'max:255'],
            'poliza' => ['nullable', 'string', 'max:255'],
            'linea' => ['nullable', 'string', 'max:255'],
            'analisis_humedad' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'analisis_peso_especifico' => ['nullable', 'numeric', 'min:0'],
            'analisis_impurezas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'analisis_quebrado' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'analisis_danados' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'analisis_otros' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'peso_bruto' => ['nullable', 'numeric', 'min:0'],
            'peso_tara' => ['nullable', 'numeric', 'min:0'],
            'peso_neto' => ['nullable', 'numeric', 'min:0'],
            'peso_total' => ['nullable', 'numeric', 'min:0'],
            'observaciones' => ['nullable', 'string'],
            'notas' => ['nullable', 'string'],
            'elaboro_nombre' => ['nullable', 'string', 'max:255'],
            'firma_recibio_nombre' => ['nullable', 'string', 'max:255'],
        ]);

        $orden = OrdenCarga::with('boletaSalida')->findOrFail($validated['orden_carga_id']);

        if ($orden->boletaSalida) {
            return redirect()
                ->route('boletas-salida.show', $orden->boletaSalida)
                ->with('info', 'La orden seleccionada ya cuenta con una boleta de salida.');
        }

        $boleta = BoletaSalida::create(array_merge($validated, [
            'folio' => BoletaSalida::generarFolio(),
            'elaboro_nombre' => $validated['elaboro_nombre'] ?? Auth::user()->name,
        ]));

        return redirect()
            ->route('boletas-salida.show', $boleta)
            ->with('success', 'Boleta de salida registrada correctamente.');
    }

    public function show(BoletaSalida $boletas_salida)
    {
        $boleta = $boletas_salida->load([
            'ordenCarga.preOrden.cliente',
            'ordenCarga.preOrden.destino',
            'ordenCarga.preOrden.chofer',
        ]);

        return view('boletas-salida.show', compact('boleta'));
    }

    public function print(BoletaSalida $boletas_salida)
    {
        $boleta = $boletas_salida->load([
            'ordenCarga.preOrden.cliente',
            'ordenCarga.preOrden.destino',
            'ordenCarga.preOrden.chofer',
            'ordenCarga.preOrden.lineaCarga',
        ]);

        return view('boletas-salida.print', compact('boleta'));
    }

    public function destroy(BoletaSalida $boletas_salida)
    {
        $boletas_salida->delete();

        return redirect()
            ->route('boletas-salida.index')
            ->with('success', 'Boleta de salida eliminada correctamente.');
    }
}
