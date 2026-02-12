<?php

namespace App\Http\Controllers;

use App\Models\ServicioLogistica;
use App\Models\Cliente;
use App\Models\LineaCarga;
use App\Models\Chofer;
use App\Models\Destino;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ServicioLogisticaController extends Controller
{
    /**
     * Lista de servicios de logística
     */
    public function index()
    {
        $query = ServicioLogistica::with(['cliente', 'lineaCarga', 'chofer', 'destino', 'usuario'])
            ->orderBy('created_at', 'desc');
        if ($search = request('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('folio', 'like', "%{$search}%")
                    ->orWhereHas('cliente', fn($c) => $c->where('nombre', 'like', "%{$search}%"))
                    ->orWhereHas('lineaCarga', fn($l) => $l->where('nombre', 'like', "%{$search}%"));
            });
        }
        $servicios = $query->paginate(request('per_page', 15))->withQueryString();
        return view('servicio-logistica.index', compact('servicios'));
    }

    /**
     * Paso 1: Crear nueva solicitud (Cliente solicita unidad)
     */
    public function create()
    {
        $clientes = Cliente::all()->sortBy(function ($c) {
            if (preg_match('/G-(\d+)/i', $c->codigo, $m)) {
                return (int) $m[1];
            }
            return 999999;
        })->values();
        
        // Debug
        \Log::info('Clientes cargados en create:', ['count' => $clientes->count()]);
        
        $lineasCarga = LineaCarga::where('estatus', true)->orderBy('nombre')->get();
        
        return view('servicio-logistica.create', compact('clientes', 'lineasCarga'));
    }

    /**
     * Guardar Paso 1: Solicitud inicial
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => ['required', 'exists:clientes,id'],
            'tipo_unidad' => ['required', 'in:thermo,caja_seca,jaula,plataforma'],
            'tipo_carga' => ['required', 'in:simple,completa'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $servicio = ServicioLogistica::create([
            'cliente_id' => $request->cliente_id,
            'tipo_unidad' => $request->tipo_unidad,
            'tipo_carga' => $request->tipo_carga,
            'estado' => 'solicitado',
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('servicio-logistica.paso2', $servicio)
            ->with('success', 'Solicitud creada. Continúa con el Paso 2: Contactar línea de transporte.');
    }

    /**
     * Paso 2: Contactar línea de transporte
     */
    public function paso2(ServicioLogistica $servicioLogistica)
    {
        $lineasCarga = LineaCarga::where('estatus', true)->orderBy('nombre')->get();
        
        return view('servicio-logistica.paso2', compact('servicioLogistica', 'lineasCarga'));
    }

    /**
     * Guardar Paso 2: Acuerdo con línea de transporte
     */
    public function guardarPaso2(Request $request, ServicioLogistica $servicioLogistica)
    {
        $validator = Validator::make($request->all(), [
            'linea_carga_id' => ['required', 'exists:lineas_carga,id'],
            'tarifa' => ['required', 'numeric', 'min:0'],
            'comision_porcentaje' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $comisionMonto = null;
        if ($request->comision_porcentaje) {
            $comisionMonto = ($request->tarifa * $request->comision_porcentaje) / 100;
        }

        $servicioLogistica->update([
            'linea_carga_id' => $request->linea_carga_id,
            'tarifa' => $request->tarifa,
            'comision_porcentaje' => $request->comision_porcentaje,
            'comision_monto' => $comisionMonto,
            'estado' => 'en_contacto',
        ]);

        return redirect()->route('servicio-logistica.paso3', $servicioLogistica)
            ->with('success', 'Acuerdo con línea de transporte registrado. Continúa con el Paso 3: Preparar orden de carga.');
    }

    /**
     * Paso 3: Preparar orden de carga (Formato DATOS DE CARGA)
     */
    public function paso3(ServicioLogistica $servicioLogistica)
    {
        $choferes = Chofer::where('estatus', true)->orderBy('nombre')->get();
        $destinos = Destino::where('estatus', true)->orderBy('nombre')->get();
        $bodegas = \App\Models\Bodega::where('estatus', true)->orderBy('nombre')->get();
        
        return view('servicio-logistica.paso3', compact('servicioLogistica', 'choferes', 'destinos', 'bodegas'));
    }

    /**
     * Guardar Paso 3: Orden de carga preparada
     */
    public function guardarPaso3(Request $request, ServicioLogistica $servicioLogistica)
    {
        $validator = Validator::make($request->all(), [
            'chofer_id' => ['nullable', 'exists:choferes,id'],
            'operador_nombre' => ['required', 'string', 'max:255'],
            'operador_celular' => ['nullable', 'string', 'max:20'],
            'operador_licencia_numero' => ['nullable', 'string', 'max:255'],
            'operador_curp_rfc' => ['nullable', 'string', 'max:255'],
            'placa_tractor' => ['nullable', 'string', 'max:255'],
            'placa_remolque' => ['nullable', 'string', 'max:255'],
            'modelo_color' => ['nullable', 'string', 'max:255'],
            'poliza_compania' => ['nullable', 'string', 'max:255'],
            'destino_id' => ['nullable', 'exists:destinos,id'],
            'destino_carga' => ['nullable', 'string', 'max:255'],
            'bodega' => ['nullable', 'string', 'max:255'],
            'criba' => ['nullable', 'string', 'max:255'],
            'cliente_empresa' => ['nullable', 'string', 'max:255'],
            'coordinador_nombre' => ['nullable', 'string', 'max:255'],
            'coordinador_numero' => ['nullable', 'string', 'max:20'],
            'fecha' => ['nullable', 'date'],
            'fecha_carga' => ['nullable', 'date'],
            'clave_interna' => ['nullable', 'string', 'max:255'],
            'notas_internas' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $servicioLogistica->update(array_merge(
            $validator->validated(),
            ['estado' => 'orden_preparada']
        ));

        return redirect()->route('servicio-logistica.show', $servicioLogistica)
            ->with('success', 'Orden de carga preparada. Puedes imprimir el formato DATOS DE CARGA.');
    }

    /**
     * Paso 4: Monitoreo y pago de comisión
     */
    public function paso4(ServicioLogistica $servicioLogistica)
    {
        return view('servicio-logistica.paso4', compact('servicioLogistica'));
    }

    /**
     * Guardar Paso 4: Actualizar estado de monitoreo
     */
    public function guardarPaso4(Request $request, ServicioLogistica $servicioLogistica)
    {
        $validator = Validator::make($request->all(), [
            'estado' => ['required', 'in:en_transito,en_destino,comision_pagada,completado'],
            'fecha_destino' => ['nullable', 'date'],
            'comision_pagada' => ['nullable', 'boolean'],
            'fecha_pago_comision' => ['nullable', 'date'],
            'notas_monitoreo' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        if ($data['estado'] === 'comision_pagada' || $data['estado'] === 'completado') {
            $data['comision_pagada'] = true;
            if (empty($data['fecha_pago_comision'])) {
                $data['fecha_pago_comision'] = now();
            }
        }

        $servicioLogistica->update($data);

        return redirect()->route('servicio-logistica.show', $servicioLogistica)
            ->with('success', 'Estado de monitoreo actualizado.');
    }

    /**
     * Paso 5: Carga de retorno
     */
    public function paso5(ServicioLogistica $servicioLogistica)
    {
        $serviciosDisponibles = ServicioLogistica::where('id', '!=', $servicioLogistica->id)
            ->where('estado', 'completado')
            ->whereNull('servicio_retorno_id')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('servicio-logistica.paso5', compact('servicioLogistica', 'serviciosDisponibles'));
    }

    /**
     * Guardar Paso 5: Asignar carga de retorno
     */
    public function guardarPaso5(Request $request, ServicioLogistica $servicioLogistica)
    {
        $validator = Validator::make($request->all(), [
            'tiene_carga_retorno' => ['nullable', 'boolean'],
            'servicio_retorno_id' => ['nullable', 'exists:servicio_logisticas,id'],
            'notas_retorno' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        if ($data['tiene_carga_retorno'] && $data['servicio_retorno_id']) {
            // Marcar el servicio de retorno como relacionado
            $servicioRetorno = ServicioLogistica::find($data['servicio_retorno_id']);
            if ($servicioRetorno) {
                $servicioRetorno->update(['servicio_retorno_id' => $servicioLogistica->id]);
            }
        }

        $servicioLogistica->update($data);

        return redirect()->route('servicio-logistica.show', $servicioLogistica)
            ->with('success', 'Carga de retorno asignada correctamente.');
    }

    /**
     * Mostrar servicio de logística
     */
    public function show(ServicioLogistica $servicioLogistica)
    {
        $servicioLogistica->load(['cliente', 'lineaCarga', 'chofer', 'destino', 'usuario', 'servicioRetorno']);
        
        return view('servicio-logistica.show', compact('servicioLogistica'));
    }

    /**
     * Imprimir formato DATOS DE CARGA
     */
    public function print(ServicioLogistica $servicioLogistica)
    {
        $servicioLogistica->load(['cliente', 'lineaCarga', 'chofer', 'destino']);
        
        return view('servicio-logistica.print', compact('servicioLogistica'));
    }

    /**
     * Editar servicio
     */
    public function edit(ServicioLogistica $servicioLogistica)
    {
        $driver = \DB::connection()->getDriverName();
        if ($driver === 'mysql' || $driver === 'mariadb') {
            $clientes = Cliente::where('estatus', true)->orderByRaw("CAST(SUBSTRING_INDEX(COALESCE(CONCAT(codigo, '-0'), '0'), '-', -1) AS UNSIGNED) ASC")->get();
        } else {
            $clientes = Cliente::where('estatus', true)->orderByRaw("CAST(REPLACE(COALESCE(codigo, '0'), 'G-', '') AS INTEGER) ASC")->get();
        }
        $lineasCarga = LineaCarga::where('estatus', true)->orderBy('nombre')->get();
        $choferes = Chofer::where('estatus', true)->orderBy('nombre')->get();
        $destinos = Destino::where('estatus', true)->orderBy('nombre')->get();
        $bodegas = \App\Models\Bodega::where('estatus', true)->orderBy('nombre')->get();
        
        return view('servicio-logistica.edit', compact('servicioLogistica', 'clientes', 'lineasCarga', 'choferes', 'destinos', 'bodegas'));
    }

    /**
     * Actualizar servicio
     */
    public function update(Request $request, ServicioLogistica $servicioLogistica)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => ['required', 'exists:clientes,id'],
            'tipo_unidad' => ['required', 'in:thermo,caja_seca,jaula,plataforma'],
            'tipo_carga' => ['required', 'in:simple,completa'],
            'linea_carga_id' => ['nullable', 'exists:lineas_carga,id'],
            'tarifa' => ['nullable', 'numeric', 'min:0'],
            'comision_porcentaje' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'estado' => ['required', 'in:solicitado,en_contacto,orden_preparada,en_transito,en_destino,comision_pagada,completado'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $validator->validated();
        if (isset($data['comision_porcentaje']) && isset($data['tarifa'])) {
            $data['comision_monto'] = ($data['tarifa'] * $data['comision_porcentaje']) / 100;
        }

        $servicioLogistica->update($data);

        return redirect()->route('servicio-logistica.show', $servicioLogistica)
            ->with('success', 'Servicio actualizado correctamente.');
    }

    /**
     * Eliminar servicio
     */
    public function destroy(ServicioLogistica $servicioLogistica)
    {
        $servicioLogistica->delete();
        
        return redirect()->route('servicio-logistica.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }
}
