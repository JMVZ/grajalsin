<?php

namespace App\Http\Controllers;

use App\Models\Chofer;
use Illuminate\Http\Request;

class ChoferController extends Controller
{
    public function index()
    {
        $choferes = Chofer::orderBy('nombre')->paginate(15);
        return view('choferes.index', compact('choferes'));
    }

    public function create()
    {
        return view('choferes.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'curp' => ['nullable', 'string', 'max:18'],
            'licencia_numero' => ['nullable', 'string', 'max:255'],
            'licencia_tipo' => ['nullable', 'string', 'max:20'],
            'licencia_vence' => ['nullable', 'date'],
            'expediente_medico_numero' => ['nullable', 'string', 'max:255'],
            'expediente_medico_vence' => ['nullable', 'date'],
            'estatus' => ['nullable', 'boolean'],
            'notas' => ['nullable', 'string'],
        ]);

        $validated['estatus'] = $request->boolean('estatus', true);

        Chofer::create($validated);

        return redirect()->route('choferes.index')->with('success', 'Chofer creado correctamente');
    }

    public function edit(Chofer $chofer)
    {
        return view('choferes.edit', compact('chofer'));
    }

    public function update(Request $request, Chofer $chofer)
    {
        $validated = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'telefono' => ['nullable', 'string', 'max:20'],
            'curp' => ['nullable', 'string', 'max:18'],
            'licencia_numero' => ['nullable', 'string', 'max:255'],
            'licencia_tipo' => ['nullable', 'string', 'max:20'],
            'licencia_vence' => ['nullable', 'date'],
            'expediente_medico_numero' => ['nullable', 'string', 'max:255'],
            'expediente_medico_vence' => ['nullable', 'date'],
            'estatus' => ['nullable', 'boolean'],
            'notas' => ['nullable', 'string'],
        ]);

        $validated['estatus'] = $request->boolean('estatus', true);

        $chofer->update($validated);

        return redirect()->route('choferes.index')->with('success', 'Chofer actualizado correctamente');
    }

    public function destroy(Chofer $chofer)
    {
        $chofer->delete();
        return redirect()->route('choferes.index')->with('success', 'Chofer eliminado');
    }
}


