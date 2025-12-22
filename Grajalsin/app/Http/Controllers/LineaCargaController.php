<?php

namespace App\Http\Controllers;

use App\Models\LineaCarga;
use Illuminate\Http\Request;

class LineaCargaController extends Controller
{
    public function index()
    {
        $lineas = LineaCarga::orderBy('nombre')->paginate(15);
        return view('lineas-carga.index', compact('lineas'));
    }

    public function create()
    {
        return view('lineas-carga.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'contacto' => ['nullable', 'string', 'max:255'],
            'base_operacion' => ['nullable', 'string', 'max:255'],
            'estatus' => ['nullable', 'boolean'],
            'notas' => ['nullable', 'string'],
        ]);

        $validated['estatus'] = $request->boolean('estatus', true);

        LineaCarga::create($validated);

        return redirect()->route('lineas-carga.index')->with('success', 'Línea de carga creada correctamente');
    }

    public function edit(LineaCarga $lineaCarga)
    {
        return view('lineas-carga.edit', compact('lineaCarga'));
    }

    public function update(Request $request, LineaCarga $lineaCarga)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'contacto' => ['nullable', 'string', 'max:255'],
            'base_operacion' => ['nullable', 'string', 'max:255'],
            'estatus' => ['nullable', 'boolean'],
            'notas' => ['nullable', 'string'],
        ]);

        $validated['estatus'] = $request->boolean('estatus', true);

        $lineaCarga->update($validated);

        return redirect()->route('lineas-carga.index')->with('success', 'Línea de carga actualizada correctamente');
    }

    public function destroy(LineaCarga $lineaCarga)
    {
        if ($lineaCarga->preOrdenes()->exists()) {
            return redirect()
                ->route('lineas-carga.index')
                ->with('warning', 'No puedes eliminar la línea porque hay pre-órdenes que aún la utilizan.');
        }

        $lineaCarga->delete();

        return redirect()->route('lineas-carga.index')->with('success', 'Línea de carga eliminada');
    }
}

