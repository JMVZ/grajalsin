<?php

namespace App\Http\Controllers;

use App\Models\PreOrden;
use App\Models\Chofer;
use App\Models\LineaCarga;
use App\Models\Destino;
use App\Models\Cliente;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PreOrdenController extends Controller
{
    public function index()
    {
        $preOrdenes = PreOrden::with(['chofer', 'lineaCarga', 'destino', 'cliente', 'productos'])
            ->orderBy('fecha', 'desc')
            ->paginate(15);
        return view('pre-ordenes.index', compact('preOrdenes'));
    }

    public function create()
    {
        $choferes = Chofer::where('estatus', true)->orderBy('nombre')->get();
        $lineasCarga = LineaCarga::where('estatus', true)->orderBy('nombre')->get();
        $destinos = Destino::where('estatus', true)->orderBy('nombre')->get();
        $clientes = Cliente::where('estatus', true)->orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        
        return view('pre-ordenes.create', compact('choferes', 'lineasCarga', 'destinos', 'clientes', 'productos'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => ['required', 'date'],
            'chofer_id' => ['required', 'exists:choferes,id'],
            'placa_tractor' => ['required', 'string', 'max:255'],
            'placa_remolque' => ['required', 'string', 'max:255'],
            'modelo' => ['nullable', 'string', 'max:255'],
            'linea_carga_id' => ['required', 'exists:lineas_carga,id'],
            'poliza_seguro' => ['nullable', 'string', 'max:255'],
            'destino_id' => ['required', 'exists:destinos,id'],
            'tarifa' => ['required', 'numeric', 'min:0'],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'coordinador_nombre' => ['nullable', 'string', 'max:255'],
            'coordinador_telefono' => ['nullable', 'string', 'max:20'],
            'constancia_fiscal' => ['nullable', 'string', 'max:255'],
            'base_linea' => ['nullable', 'string', 'max:255'],
            'precio_factura' => ['nullable', 'numeric', 'min:0'],
            'notas' => ['nullable', 'string'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.producto_id' => ['required', 'exists:productos,id'],
            'productos.*.cantidad' => ['nullable', 'numeric', 'min:0.01'],
            'productos.*.tipo_carga' => ['required', 'in:granel,costal'],
            'productos.*.toneladas' => ['nullable', 'numeric', 'min:0.01'],
        ]);

        $validator->after(function ($validator) use ($request) {
            foreach ($request->input('productos', []) as $index => $producto) {
                $tipo = $producto['tipo_carga'] ?? null;
                $cantidad = $producto['cantidad'] ?? null;
                $toneladas = $producto['toneladas'] ?? null;

                if ($tipo === 'granel') {
                    if (blank($toneladas)) {
                        $validator->errors()->add("productos.$index.toneladas", 'Indica las toneladas para carga a granel.');
                    }
                } elseif ($tipo === 'costal') {
                    if (blank($cantidad)) {
                        $validator->errors()->add("productos.$index.cantidad", 'Indica la cantidad de costales.');
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $datosPreOrden = $validated;
        $productosData = $datosPreOrden['productos'];
        unset($datosPreOrden['productos']);

        $preOrden = PreOrden::create($datosPreOrden);

        // Adjuntar productos con sus datos
        foreach ($productosData as $productoData) {
            $preOrden->productos()->attach($productoData['producto_id'], [
                'cantidad' => $productoData['tipo_carga'] === 'costal' ? ($productoData['cantidad'] ?? null) : null,
                'tipo_carga' => $productoData['tipo_carga'],
                'toneladas' => $productoData['tipo_carga'] === 'granel' ? ($productoData['toneladas'] ?? null) : null,
            ]);
        }

        return redirect()->route('pre-ordenes.index')->with('success', 'Pre-orden creada correctamente');
    }

    public function show(PreOrden $preOrden)
    {
        $preOrden->load(['chofer', 'lineaCarga', 'destino', 'cliente', 'productos']);
        return view('pre-ordenes.show', compact('preOrden'));
    }

    public function print(PreOrden $preOrden)
    {
        $preOrden->load(['chofer', 'lineaCarga', 'destino', 'cliente', 'productos']);
        return view('pre-ordenes.print', compact('preOrden'));
    }

    public function edit(PreOrden $preOrden)
    {
        $choferes = Chofer::where('estatus', true)->orderBy('nombre')->get();
        $lineasCarga = LineaCarga::where('estatus', true)->orderBy('nombre')->get();
        $destinos = Destino::where('estatus', true)->orderBy('nombre')->get();
        $clientes = Cliente::where('estatus', true)->orderBy('nombre')->get();
        $productos = Producto::where('activo', true)->orderBy('nombre')->get();
        
        return view('pre-ordenes.edit', compact('preOrden', 'choferes', 'lineasCarga', 'destinos', 'clientes', 'productos'));
    }

    public function update(Request $request, PreOrden $preOrden)
    {
        $validator = Validator::make($request->all(), [
            'fecha' => ['required', 'date'],
            'chofer_id' => ['required', 'exists:choferes,id'],
            'placa_tractor' => ['required', 'string', 'max:255'],
            'placa_remolque' => ['required', 'string', 'max:255'],
            'modelo' => ['nullable', 'string', 'max:255'],
            'linea_carga_id' => ['required', 'exists:lineas_carga,id'],
            'poliza_seguro' => ['nullable', 'string', 'max:255'],
            'destino_id' => ['required', 'exists:destinos,id'],
            'tarifa' => ['required', 'numeric', 'min:0'],
            'cliente_id' => ['required', 'exists:clientes,id'],
            'coordinador_nombre' => ['nullable', 'string', 'max:255'],
            'coordinador_telefono' => ['nullable', 'string', 'max:20'],
            'constancia_fiscal' => ['nullable', 'string', 'max:255'],
            'base_linea' => ['nullable', 'string', 'max:255'],
            'precio_factura' => ['nullable', 'numeric', 'min:0'],
            'notas' => ['nullable', 'string'],
            'productos' => ['required', 'array', 'min:1'],
            'productos.*.producto_id' => ['required', 'exists:productos,id'],
            'productos.*.cantidad' => ['nullable', 'numeric', 'min:0.01'],
            'productos.*.tipo_carga' => ['required', 'in:granel,costal'],
            'productos.*.toneladas' => ['nullable', 'numeric', 'min:0.01'],
        ]);

        $validator->after(function ($validator) use ($request) {
            foreach ($request->input('productos', []) as $index => $producto) {
                $tipo = $producto['tipo_carga'] ?? null;
                $cantidad = $producto['cantidad'] ?? null;
                $toneladas = $producto['toneladas'] ?? null;

                if ($tipo === 'granel') {
                    if (blank($toneladas)) {
                        $validator->errors()->add("productos.$index.toneladas", 'Indica las toneladas para carga a granel.');
                    }
                } elseif ($tipo === 'costal') {
                    if (blank($cantidad)) {
                        $validator->errors()->add("productos.$index.cantidad", 'Indica la cantidad de costales.');
                    }
                }
            }
        });

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $datosPreOrden = $validated;
        $productosData = $datosPreOrden['productos'];
        unset($datosPreOrden['productos']);

        $preOrden->update($datosPreOrden);

        // Sincronizar productos
        $productosSincronizar = [];
        foreach ($productosData as $productoData) {
            $productosSincronizar[$productoData['producto_id']] = [
                'cantidad' => $productoData['tipo_carga'] === 'costal' ? ($productoData['cantidad'] ?? null) : null,
                'tipo_carga' => $productoData['tipo_carga'],
                'toneladas' => $productoData['tipo_carga'] === 'granel' ? ($productoData['toneladas'] ?? null) : null,
            ];
        }
        $preOrden->productos()->sync($productosSincronizar);

        return redirect()->route('pre-ordenes.index')->with('success', 'Pre-orden actualizada correctamente');
    }

    public function destroy(PreOrden $preOrden)
    {
        $preOrden->delete();
        return redirect()->route('pre-ordenes.index')->with('success', 'Pre-orden eliminada');
    }
}

