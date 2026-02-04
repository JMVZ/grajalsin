<?php

namespace App\Http\Controllers;

use App\Models\Destino;
use Illuminate\Http\Request;

class DestinoController extends Controller
{
    public function index()
    {
        $query = Destino::query()->orderBy('nombre');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                    ->orWhere('estado', 'like', "%{$search}%");
            });
        }
        $destinos = $query->paginate(request('per_page', 15))->withQueryString();
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
            'estado' => ['nullable', 'string', 'max:100'],
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
            'estado' => ['nullable', 'string', 'max:100'],
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

