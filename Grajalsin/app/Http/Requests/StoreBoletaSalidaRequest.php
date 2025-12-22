<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBoletaSalidaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'orden_carga_id' => [
                'required',
                'exists:ordenes_carga,id',
                Rule::unique('boletas_salida', 'orden_carga_id'),
            ],
            'fecha' => ['required', 'date'],
            'cliente' => ['nullable', 'string', 'max:255'],
            'contacto' => ['nullable', 'string', 'max:255'],
            'producto' => ['nullable', 'string', 'max:255'],
            'variedad' => ['nullable', 'string', 'max:255'],
            'cosecha' => ['nullable', 'string', 'max:255'],
            'destino' => ['nullable', 'string', 'max:255'],
            'origen' => ['nullable', 'string', 'max:255'],
            'envase' => ['nullable', 'string', 'max:255'],
            'referencia' => ['nullable', 'string', 'max:255'],
            'observaciones' => ['nullable', 'string'],
            'nota_mes' => ['nullable', 'string'],
            'operador_nombre' => ['required', 'string', 'max:255'],
            'operador_celular' => ['nullable', 'string', 'max:255'],
            'operador_licencia' => ['nullable', 'string', 'max:255'],
            'operador_rfc_curp' => ['nullable', 'string', 'max:255'],
            'camion' => ['nullable', 'string', 'max:255'],
            'placas' => ['nullable', 'string', 'max:255'],
            'poliza' => ['nullable', 'string', 'max:255'],
            'linea' => ['nullable', 'string', 'max:255'],
            'humedad' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'peso_especifico' => ['nullable', 'numeric', 'min:0'],
            'impurezas' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'quebrado' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'danados' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'otros' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'peso_bruto' => ['nullable', 'numeric', 'min:0'],
            'peso_tara' => ['nullable', 'numeric', 'min:0'],
            'peso_neto' => ['nullable', 'numeric', 'min:0'],
            'peso_total' => ['nullable', 'numeric', 'min:0'],
            'elaboro_nombre' => ['nullable', 'string', 'max:255'],
            'operador_firma' => ['nullable', 'string', 'max:255'],
            'recibe_nombre' => ['nullable', 'string', 'max:255'],
            'recibe_firma' => ['nullable', 'string', 'max:255'],
        ];
    }
}


