<?php

namespace App\Http\Controllers;

use App\Models\Bodega;
use Illuminate\Http\Request;

class BodegaController extends Controller
{
    public function index()
    {
        $query = Bodega::query()->where('estatus', true)->orderBy('nombre');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('ubicacion', 'like', "%{$search}%")
                    ->orWhere('clave', 'like', "%{$search}%");
            });
        }
        $bodegas = $query->paginate(request('per_page', 15))->withQueryString();
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
            'clave' => ['nullable', 'string', 'max:20'],
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
            'clave' => ['nullable', 'string', 'max:20'],
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


