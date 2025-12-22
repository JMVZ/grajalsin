<?php

namespace App\Http\Controllers;

use App\Models\OrdenCarga;
use App\Models\PreOrden;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrdenCargaController extends Controller
{
    public function index()
    {
        $ordenes = OrdenCarga::with('preOrden')->orderByDesc('fecha_entrada')->paginate(15);
        return view('ordenes-carga.index', compact('ordenes'));
    }

    public function create(Request $request)
    {
        $preOrden = null;
        if ($request->filled('pre_orden')) {
            $preOrden = PreOrden::with(['chofer', 'lineaCarga', 'destino', 'cliente', 'productos', 'ordenCarga'])
                ->findOrFail($request->query('pre_orden'));

            if ($preOrden->ordenCarga) {
                return redirect()
                    ->route('ordenes-carga.create')
                    ->with('warning', 'La pre-orden seleccionada ya cuenta con una orden de carga.');
            }
        }

        $preOrdenesDisponibles = PreOrden::with('chofer')
            ->doesntHave('ordenCarga')
            ->orderByDesc('fecha')
            ->get();

        return view('ordenes-carga.create', [
            'preOrdenSeleccionada' => $preOrden,
            'preOrdenesDisponibles' => $preOrdenesDisponibles,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pre_orden_id' => ['required', 'exists:pre_ordenes,id'],
            'fecha_entrada' => ['required', 'date'],
            'origen' => ['nullable', 'string', 'max:255'],
            'bodega' => ['nullable', 'string', 'max:255'],
            'destino' => ['nullable', 'string', 'max:255'],
            'peso' => ['nullable', 'string', 'max:255'],
            'producto' => ['nullable', 'string', 'max:255'],
            'presentacion' => ['nullable', 'string', 'max:255'],
            'costal' => ['nullable', 'string', 'max:255'],
            'observaciones' => ['nullable', 'string'],
            'operador_nombre' => ['required', 'string', 'max:255'],
            'operador_celular' => ['nullable', 'string', 'max:255'],
            'operador_licencia' => ['nullable', 'string', 'max:255'],
            'operador_curp' => ['nullable', 'string', 'max:255'],
            'placas_camion' => ['nullable', 'string', 'max:255'],
            'descripcion' => ['nullable', 'string', 'max:255'],
            'linea' => ['nullable', 'string', 'max:255'],
            'poliza' => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'elaboro_celular' => ['nullable', 'string', 'max:255'],
            'recibe_nombre' => ['nullable', 'string', 'max:255'],
            'recibe_celular' => ['nullable', 'string', 'max:255'],
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $preOrden = PreOrden::with('ordenCarga')->findOrFail($validated['pre_orden_id']);
        if ($preOrden->ordenCarga) {
            return back()->withErrors(['pre_orden_id' => 'Esta pre-orden ya tiene una orden de carga registrada.'])->withInput();
        }

        $orden = OrdenCarga::create(array_merge($validated, [
            'folio' => OrdenCarga::generarFolio(),
            'elaboro_nombre' => Auth::user()->name,
            'elaboro_celular' => $validated['elaboro_celular'] ?? null,
        ]));

        return redirect()->route('ordenes-carga.show', $orden)->with('success', 'Orden de carga registrada correctamente.');
    }

    public function show(OrdenCarga $ordenes_carga)
    {
        $orden = $ordenes_carga->load(['preOrden', 'boletaSalida']);
        return view('ordenes-carga.show', compact('orden'));
    }

    public function print(OrdenCarga $ordenes_carga)
    {
        $orden = $ordenes_carga->load('preOrden');
        return view('ordenes-carga.print', compact('orden'));
    }

    public function destroy(OrdenCarga $ordenes_carga)
    {
        if ($ordenes_carga->boletaSalida) {
            return redirect()
                ->route('ordenes-carga.index')
                ->with('warning', 'No se puede eliminar la orden porque tiene una boleta de salida asociada. Elimina primero la boleta.');
        }

        $ordenes_carga->delete();
        return redirect()->route('ordenes-carga.index')->with('success', 'Orden de carga eliminada.');
    }
}


