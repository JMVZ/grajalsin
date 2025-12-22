<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boleta de Salida {{ $boleta->folio }}</title>
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
            text-align: left;
            border-bottom: 2px solid #0f5132;
            padding-bottom: 8px;
            margin-bottom: 10px;
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
            margin-bottom: 10px;
        }
        table td {
            padding: 4px 6px;
            font-size: 12px;
            vertical-align: top;
        }
        .label {
            width: 140px;
            font-weight: bold;
            text-transform: uppercase;
            color: #000;
        }
        .value {
            font-weight: normal;
            color: #000;
        }
        .section-title {
            background: #0f5132;
            color: white;
            text-align: center;
            font-weight: bold;
            text-transform: uppercase;
            padding: 6px;
            margin: 10px 0 5px 0;
            font-size: 13px;
            letter-spacing: 1px;
        }
        .analysis-table, .weight-table {
            width: 100%;
            margin: 8px 0;
        }
        .analysis-table td, .weight-table td {
            border: 1px solid #0f5132;
            padding: 5px;
            text-align: center;
        }
        .analysis-table .header-cell, .weight-table .header-cell {
            background: #f0f0f0;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 11px;
        }
        .observations {
            margin-top: 10px;
            padding: 8px;
            border: 1px solid #0f5132;
            min-height: 50px;
            font-size: 11px;
        }
        .footer {
            margin-top: 15px;
            border-top: 2px solid #0f5132;
            padding-top: 10px;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }
        .footer div { width: 48%; }
        .footer .label-footer {
            font-weight: bold;
            margin-bottom: 4px;
            text-transform: uppercase;
        }
        .footer .signature-line {
            border-bottom: 1px solid #0f5132;
            min-height: 25px;
            margin-bottom: 5px;
        }
        @media print {
            body { background: white; padding: 0; }
            .page { border-width: 1px; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page">
        <div class="header">
            <div class="header-logo" style="display: flex; justify-content: center; align-items: center; margin-bottom: 8px;">
                <img src="{{ asset('grajalsin-removebg-preview.png') }}" alt="Grajalsin Logo" style="height: 60px; width: auto;">
            </div>
            <h1>GRAJALSIN, SPR DE RL</h1>
            <p>Av Marchal 4014, Fracc. Granada, CP 80058, Culiacán de Rosales, Sinaloa</p>
            <p>cel. 667 142 6156 y 667 185 6855</p>
        </div>

        <div class="title-row">
            <h2>BOLETA DE SALIDA</h2>
            <div><span class="label">FOLIO:</span> <span class="folio">{{ $boleta->folio }}</span></div>
        </div>

        <table>
            <tr>
                <td class="label">CLIENTE:</td>
                <td class="value">{{ strtoupper($boleta->cliente_tipo ?? '') }}</td>
                <td class="label" style="width: 110px;">FECHA:</td>
                <td class="value">{{ $boleta->fecha->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td class="label">NOMBRE:</td>
                <td class="value">{{ strtoupper($boleta->cliente_nombre) }}</td>
                <td class="label">REFERENCIA:</td>
                <td class="value">{{ strtoupper($boleta->referencia ?? '') }}</td>
            </tr>
            <tr>
                <td class="label">PRODUCTO:</td>
                <td class="value">{{ strtoupper($boleta->producto) }}</td>
                <td class="label">VARIEDAD:</td>
                <td class="value">{{ strtoupper($boleta->variedad ?? '') }}</td>
            </tr>
            <tr>
                <td class="label">COSECHA:</td>
                <td class="value">{{ strtoupper($boleta->cosecha ?? '') }}</td>
                <td class="label">ENVASE:</td>
                <td class="value">{{ strtoupper($boleta->envase ?? '') }}</td>
            </tr>
            <tr>
                <td class="label">DESTINO:</td>
                <td class="value">{{ strtoupper($boleta->destino ?? '') }}</td>
                <td class="label">ORIGEN:</td>
                <td class="value">{{ strtoupper($boleta->origen ?? '') }}</td>
            </tr>
        </table>

        <table style="margin-top: 8px;">
            <tr>
                <td class="label">OPERADOR:</td>
                <td class="value">{{ strtoupper($boleta->operador_nombre) }}</td>
                <td class="label" style="width: 110px;">CELULAR:</td>
                <td class="value">{{ $boleta->operador_celular ?? '' }}</td>
            </tr>
            <tr>
                <td class="label">LICENCIA:</td>
                <td class="value">{{ strtoupper($boleta->operador_licencia ?? '') }}</td>
                <td class="label">RFC / CURP:</td>
                <td class="value">{{ strtoupper($boleta->operador_curp ?? '') }}</td>
            </tr>
            <tr>
                <td class="label">CAMIÓN:</td>
                <td class="value">{{ strtoupper($boleta->camion ?? '') }}</td>
                <td class="label">PLACAS:</td>
                <td class="value">{{ strtoupper($boleta->placas ?? '') }}</td>
            </tr>
            <tr>
                <td class="label">PÓLIZA:</td>
                <td class="value">{{ strtoupper($boleta->poliza ?? '') }}</td>
                <td class="label">LÍNEA:</td>
                <td class="value">{{ strtoupper($boleta->linea ?? '') }}</td>
            </tr>
        </table>

        <div class="section-title">ANÁLISIS DEL PRODUCTO</div>
        <table class="analysis-table">
            <tr>
                <td class="header-cell" style="width: 180px;"></td>
                <td class="header-cell">KG / TON</td>
            </tr>
            <tr>
                <td class="label">HUMEDAD</td>
                <td class="value">{{ $boleta->analisis_humedad ? number_format($boleta->analisis_humedad, 2) . '%' : '' }}</td>
            </tr>
            <tr>
                <td class="label">P. ESPECIFICO</td>
                <td class="value">{{ $boleta->analisis_peso_especifico ? number_format($boleta->analisis_peso_especifico, 2) : '' }}</td>
            </tr>
            <tr>
                <td class="label">IMPUREZAS (1000 GR)</td>
                <td class="value">{{ $boleta->analisis_impurezas ? number_format($boleta->analisis_impurezas, 2) . '%' : '' }}</td>
            </tr>
            <tr>
                <td class="label">QUEBRADO</td>
                <td class="value">{{ $boleta->analisis_quebrado ? number_format($boleta->analisis_quebrado, 2) . '%' : '' }}</td>
            </tr>
            <tr>
                <td class="label">DAÑADOS (100 GR)</td>
                <td class="value">{{ $boleta->analisis_danados ? number_format($boleta->analisis_danados, 2) . '%' : '' }}</td>
            </tr>
            <tr>
                <td class="label">OTROS:</td>
                <td class="value">{{ $boleta->analisis_otros ? number_format($boleta->analisis_otros, 2) . '%' : '' }}</td>
            </tr>
        </table>

        <div class="section-title">PESO BASCULA</div>
        <table class="weight-table">
            <tr>
                <td class="header-cell">PESO BRUTO</td>
                <td class="header-cell">PESO TARA</td>
            </tr>
            <tr>
                <td class="value">{{ $boleta->peso_bruto ? number_format($boleta->peso_bruto, 0, '', ',') : '' }}</td>
                <td class="value">{{ $boleta->peso_tara ? number_format($boleta->peso_tara, 0, '', ',') : '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">PESO NETO</td>
                <td class="header-cell">PESO TOTAL</td>
            </tr>
            <tr>
                <td class="value">{{ $boleta->peso_neto ? number_format($boleta->peso_neto, 0, '', ',') : '' }}</td>
                <td class="value">{{ $boleta->peso_total ? number_format($boleta->peso_total, 0, '', ',') : '' }}</td>
            </tr>
        </table>

        @if($boleta->observaciones)
        <div style="margin-top: 10px;">
            <div class="label" style="margin-bottom: 3px;">OBSERVACIONES:</div>
            <div class="observations">
                {{ strtoupper($boleta->observaciones) }}
            </div>
        </div>
        @endif

        <div class="footer">
            <div>
                <div class="label-footer">ELABORÓ:</div>
                <div class="signature-line">{{ $boleta->elaboro_nombre ?? '' }}</div>
            </div>
            <div>
                <div class="label-footer">FIRMA RECIBIDO:</div>
                <div class="signature-line">{{ strtoupper($boleta->firma_recibio_nombre ?? 'OPERADOR') }}</div>
            </div>
        </div>
    </div>
</body>
</html>
