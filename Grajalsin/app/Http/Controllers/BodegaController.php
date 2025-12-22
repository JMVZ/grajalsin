<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use Illuminate\Http\Request;

class BodegaController extends Controller
{
    public function index()
    {
        $bodegas = Bodega::where('estatus', true)->orderBy('nombre')->paginate(15);
        return view('bodegas.index', compact('bodegas'));
    }

    public function create()
    {
        return view('bodegas.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estatus' => ['nullable', 'boolean'],
            'notas' => ['nullable', 'string'],
        ]);

        $validated['estatus'] = $request->boolean('estatus', true);
        Bodega::create($validated);
        return redirect()->route('bodegas.index')->with('success', 'Bodega creada correctamente');
    }

    public function edit(Bodega $bodega)
    {
        return view('bodegas.edit', compact('bodega'));
    }

    public function update(Request $request, Bodega $bodega)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'ubicacion' => ['nullable', 'string', 'max:255'],
            'estatus' => ['nullable', 'boolean'],
            'notas' => ['nullable', 'string'],
        ]);

        $validated['estatus'] = $request->boolean('estatus', true);
        $bodega->update($validated);
        return redirect()->route('bodegas.index')->with('success', 'Bodega actualizada');
    }

    public function destroy(Bodega $bodega)
    {
        $bodega->delete();
        return redirect()->route('bodegas.index')->with('success', 'Bodega eliminada');
    }
}


