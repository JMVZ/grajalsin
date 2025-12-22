<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    public function index()
    {
        $destinos = Destino::orderBy('nombre')->paginate(15);
        return view('destinos.index', compact('destinos'));
    }

    public function create()
    {
        return view('destinos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'estatus' => ['nullable', 'boolean'],
            'notas' => ['nullable', 'string'],
        ]);

        $validated['estatus'] = $request->boolean('estatus', true);

        Destino::create($validated);

        return redirect()->route('destinos.index')->with('success', 'Destino creado correctamente');
    }

    public function edit(Destino $destino)
    {
        return view('destinos.edit', compact('destino'));
    }

    public function update(Request $request, Destino $destino)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'estatus' => ['nullable', 'boolean'],
            'notas' => ['nullable', 'string'],
        ]);

        $validated['estatus'] = $request->boolean('estatus', true);

        $destino->update($validated);

        return redirect()->route('destinos.index')->with('success', 'Destino actualizado correctamente');
    }

    public function destroy(Destino $destino)
    {
        $destino->delete();
        return redirect()->route('destinos.index')->with('success', 'Destino eliminado');
    }
}

