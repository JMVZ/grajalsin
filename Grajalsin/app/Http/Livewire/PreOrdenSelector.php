<?php

namespace App\Http\Livewire;

use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class PreOrdenSelector extends Component
{
    public Collection $preOrdenesDisponibles;
    public $preOrdenSeleccionada;

    public function mount($preOrdenesDisponibles, $preOrdenSeleccionada = null)
    {
        $this->preOrdenesDisponibles = $preOrdenesDisponibles;
        $this->preOrdenSeleccionada = $preOrdenSeleccionada;
    }

    public function updatedPreOrdenSeleccionada($value)
    {
        if ($value) {
            return redirect()->route('ordenes-carga.create', ['pre_orden' => $value]);
        }
    }

    public function render()
    {
        return view('livewire.pre-orden-selector');
    }
}


