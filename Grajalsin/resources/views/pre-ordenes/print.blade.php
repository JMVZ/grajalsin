@php
    $chofer = $preOrden->chofer;
    $linea = $preOrden->lineaCarga;
    $destino = $preOrden->destino;
    $cliente = $preOrden->cliente;
    $bodega = $preOrden->base_linea ?? optional($preOrden->bodega)->nombre ?? '';

    $tieneGranel = false;
    $tieneCostal = false;
    $totalToneladas = 0;
    $totalCostales = 0;

    foreach ($preOrden->productos as $producto) {
        if ($producto->pivot->tipo_carga === 'granel') {
            $tieneGranel = true;
            $totalToneladas += $producto->pivot->toneladas ?? 0;
        }
        if ($producto->pivot->tipo_carga === 'costal') {
            $tieneCostal = true;
            $totalCostales += $producto->pivot->cantidad ?? 0;
        }
    }

    $totalToneladas = $tieneGranel ? number_format($totalToneladas, 2) : null;
    $totalCostales = $tieneCostal ? number_format($totalCostales, 2) : null;
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pre-orden {{ $preOrden->folio }}</title>
    <style>
        * { box-sizing: border-box; font-family: 'Arial Narrow', Arial, sans-serif; margin: 0; padding: 0; }
        body { margin: 0; padding: 20px; background: #ffffff; font-size: 13px; }
        .page {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #0f5132;
            padding: 15px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f5132;
            padding-bottom: 8px;
            margin-bottom: 10px;
        }
        .header-logo {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 8px;
        }
        .header-logo img {
            height: 60px;
            width: auto;
        }
        .header h1 {
            margin: 0;
            color: #0f5132;
            font-size: 16px;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .header p {
            margin: 2px 0;
            font-size: 11px;
            color: #333;
        }
        .title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 10px 0;
            border-bottom: 1px solid #0f5132;
            padding-bottom: 6px;
        }
        .title-row h2 {
            margin: 0;
            font-size: 18px;
            letter-spacing: 1.5px;
            font-weight: bold;
        }
        .title-row .folio {
            font-weight: 700;
            color: #c62828;
            font-size: 16px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        td {
            padding: 6px 0;
            vertical-align: top;
        }
        .label {
            width: 130px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .dots {
            border-bottom: 1px dotted #0f5132;
            margin: 0 8px;
            flex-grow: 1;
        }
        .row {
            display: flex;
            justify-content: space-between;
        }
        .row-item {
            display: flex;
            align-items: baseline;
            width: 49%;
        }
        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            background: #0f5132;
            color: white;
        }
        .summary div {
            padding: 12px 16px;
            text-align: center;
        }
        .summary span {
            display: block;
        }
        .summary-label {
            font-size: 11px;
            letter-spacing: 1px;
            opacity: .85;
            text-transform: uppercase;
        }
        .summary-value {
            font-size: 16px;
            font-weight: 700;
        }
        .observaciones {
            margin-top: 18px;
            border-top: 2px solid #0f5132;
            padding-top: 12px;
        }
        @media print {
            body {
                background: white;
                padding: 0;
            }
            .page {
                border-width: 1px;
            }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page">
        <div class="header">
            <div class="header-logo">
                <img src="{{ asset('grajalsin-removebg-preview.png') }}" alt="Grajalsin Logo">
            </div>
            <h1>GRAJALSIN, SPR DE RL</h1>
            <p>Av Marchal 4014, Fracc. Granada, CP 80058, Culiacán de Rosales, Sinaloa</p>
            <p>cel. 667 142 6156 y 667 185 6855</p>
        </div>

        <div class="title-row">
            <h2>PRE-ORDEN DE CARGA</h2>
            <div><span class="label">FOLIO:</span> <span class="folio">{{ $preOrden->folio }}</span></div>
        </div>

        <table>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Fecha:</span><span class="dots"></span><span>{{ $preOrden->fecha->format('d/m/Y') }}</span></div>
                        <div class="row-item"><span class="label">Operador:</span><span class="dots"></span><span>{{ strtoupper($chofer->nombre ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Celular:</span><span class="dots"></span><span>{{ $chofer->telefono ?? '---' }}</span></div>
                        <div class="row-item"><span class="label">Licencia:</span><span class="dots"></span><span>{{ strtoupper($chofer->licencia_numero ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">CURP:</span><span class="dots"></span><span>{{ strtoupper($chofer->curp ?? '') }}</span></div>
                        <div class="row-item"><span class="label">Expediente médico:</span><span class="dots"></span><span>{{ strtoupper($chofer->expediente_medico_numero ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Placa tractor:</span><span class="dots"></span><span>{{ strtoupper($preOrden->placa_tractor ?? '') }}</span></div>
                        <div class="row-item"><span class="label">Placa remolque:</span><span class="dots"></span><span>{{ strtoupper($preOrden->placa_remolque ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Modelo:</span><span class="dots"></span><span>{{ strtoupper($preOrden->modelo ?? '') }}</span></div>
                        <div class="row-item"><span class="label">Línea:</span><span class="dots"></span><span>{{ strtoupper($linea->nombre ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Póliza seguro:</span><span class="dots"></span><span>{{ strtoupper($preOrden->poliza_seguro ?? '') }}</span></div>
                        <div class="row-item"><span class="label">Destino:</span><span class="dots"></span><span>{{ strtoupper($destino->nombre ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Cliente:</span><span class="dots"></span><span>{{ strtoupper($cliente->nombre ?? '') }}</span></div>
                        <div class="row-item"><span class="label">Tarifa:</span><span class="dots"></span><span>${{ number_format($preOrden->tarifa ?? 0, 2) }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Bodega:</span><span class="dots"></span><span>{{ strtoupper($bodega) }}</span></div>
                        <div class="row-item"><span class="label">Base línea:</span><span class="dots"></span><span>{{ strtoupper($preOrden->base_linea ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            @if($tieneGranel || $tieneCostal)
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item">
                            <span class="label">Tipo carga:</span><span class="dots"></span>
                            <span>
                                @if($tieneGranel) GRANEL ({{ $totalToneladas }} TON) @endif
                                @if($tieneGranel && $tieneCostal) / @endif
                                @if($tieneCostal) COSTAL ({{ $totalCostales }} UDS) @endif
                            </span>
                        </div>
                        <div class="row-item"><span class="label">Criba:</span><span class="dots"></span><span>{{ strtoupper($preOrden->criba ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            @endif
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Coordinador:</span><span class="dots"></span><span>{{ strtoupper($preOrden->coordinador_nombre ?? '') }}</span></div>
                        <div class="row-item"><span class="label">Tel. coordinador:</span><span class="dots"></span><span>{{ $preOrden->coordinador_telefono ?? '' }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Constancia fiscal:</span><span class="dots"></span><span>{{ strtoupper($preOrden->constancia_fiscal ?? '') }}</span></div>
                        <div class="row-item"><span class="label">RFC:</span><span class="dots"></span><span>{{ strtoupper($cliente->rfc ?? '') }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Precio factura:</span><span class="dots"></span><span>{{ $preOrden->precio_factura ? '$' . number_format($preOrden->precio_factura, 2) : '---' }}</span></div>
                        <div class="row-item"></div>
                    </div>
                </td>
            </tr>
        </table>

        @if($preOrden->notas)
        <div class="observaciones" style="margin-top: 18px; border-top: 2px solid #0f5132; padding-top: 12px;">
            <span class="label">Observaciones:</span>
            <div style="min-height: 60px; border: 1px solid #0f5132; margin-top: 6px; padding: 4px 6px;">
                {{ $preOrden->notas }}
            </div>
        </div>
        @endif

    </div>
</body>
</html>

