@php
    $orden = $orden->loadMissing('preOrden.chofer');
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Carga {{ $orden->folio }}</title>
    <style>
        * { box-sizing: border-box; font-family: 'Arial Narrow', Arial, sans-serif; }
        body { margin: 0; padding: 24px; background: #ffffff; }
        .page {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
            border: 2px solid #0f5132;
            padding: 18px 24px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #0f5132;
            padding-bottom: 12px;
            margin-bottom: 12px;
        }
        .header h1 {
            margin: 0;
            color: #0f5132;
            letter-spacing: 1.2px;
        }
        .header p {
            margin: 2px 0;
            font-size: 12px;
        }
        .title-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 18px 0;
            border-bottom: 1px solid #0f5132;
            padding-bottom: 10px;
        }
        .title-row h2 {
            margin: 0;
            font-size: 20px;
            letter-spacing: 1px;
        }
        .title-row .folio {
            font-weight: 700;
            color: #c62828;
            font-size: 18px;
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
        .observaciones {
            margin-top: 18px;
            border-top: 2px solid #0f5132;
            padding-top: 12px;
        }
        .footer {
            margin-top: 24px;
            border-top: 2px solid #0f5132;
            padding-top: 12px;
            display: flex;
            justify-content: space-between;
            font-size: 13px;
        }
        .footer div { width: 48%; }
        .footer .label {
            display: block;
            margin-bottom: 4px;
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page">
        <div class="header">
            <div style="display: flex; justify-content: center; align-items: center; margin-bottom: 8px;">
                <img src="{{ asset('grajalsin-removebg-preview.png') }}" alt="Grajalsin Logo" style="height: 60px; width: auto;">
            </div>
            <h1>GRAJALSIN, SPR DE RL</h1>
            <p>Av Marchal 4014, Fracc. Granada, CP 80058, Culiacán de Rosales, Sinaloa</p>
            <p>cel. 667 142 6156 y 667 185 6855</p>
        </div>

        <div class="title-row">
            <h2>ORDEN DE CARGA</h2>
            <div><span class="label">Folio:</span> <span class="folio">{{ $orden->folio }}</span></div>
        </div>

        <table>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Fecha entrada:</span><span class="dots"></span><span>{{ $orden->fecha_entrada->format('d/m/Y') }}</span></div>
                        <div class="row-item"><span class="label">Operador:</span><span class="dots"></span><span>{{ $orden->operador_nombre }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Origen:</span><span class="dots"></span><span>{{ $orden->origen }}</span></div>
                        <div class="row-item"><span class="label">Celular:</span><span class="dots"></span><span>{{ $orden->operador_celular }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Bodega:</span><span class="dots"></span><span>{{ $orden->bodega }}</span></div>
                        <div class="row-item"><span class="label">Datos licencia:</span><span class="dots"></span><span>{{ $orden->operador_licencia }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Destino:</span><span class="dots"></span><span>{{ $orden->destino }}</span></div>
                        <div class="row-item"><span class="label">RFC / CURP:</span><span class="dots"></span><span>{{ $orden->operador_curp }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Peso:</span><span class="dots"></span><span>{{ $orden->peso }}</span></div>
                        <div class="row-item"><span class="label">Placas camión:</span><span class="dots"></span><span>{{ $orden->placas_camion }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Producto:</span><span class="dots"></span><span>{{ $orden->producto }}</span></div>
                        <div class="row-item"><span class="label">Descripción:</span><span class="dots"></span><span>{{ $orden->descripcion }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Presentación:</span><span class="dots"></span><span>{{ $orden->presentacion }}</span></div>
                        <div class="row-item"><span class="label">Línea:</span><span class="dots"></span><span>{{ $orden->linea }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Costal:</span><span class="dots"></span><span>{{ $orden->costal }}</span></div>
                        <div class="row-item"><span class="label">Póliza:</span><span class="dots"></span><span>{{ $orden->poliza }}</span></div>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="row">
                        <div class="row-item"><span class="label">Tipo:</span><span class="dots"></span><span>{{ $orden->presentacion === 'Costal' ? trim($orden->costal) : 'libre' }}</span></div>
                        <div class="row-item"><span class="label">Referencia:</span><span class="dots"></span><span>{{ $orden->referencia }}</span></div>
                    </div>
                </td>
            </tr>
        </table>

        <div class="observaciones">
            <span class="label">Observaciones:</span>
            <div style="min-height: 60px; border: 1px solid #0f5132; margin-top: 6px; padding: 4px 6px;">
                {{ $orden->observaciones }}
            </div>
        </div>

        <div class="footer">
            <div>
                <span class="label">Elaboró:</span>
                <div style="border-bottom: 1px solid #0f5132; padding-bottom: 4px; margin-bottom: 6px;">{{ $orden->elaboro_nombre }}</div>
                <span class="label">Celular:</span>
                <div>{{ $orden->elaboro_celular }}</div>
            </div>
            <div>
                <span class="label">Recibe:</span>
                <div style="border-bottom: 1px solid #0f5132; padding-bottom: 4px; margin-bottom: 6px;">{{ $orden->recibe_nombre }}</div>
                <span class="label">Celular:</span>
                <div>{{ $orden->recibe_celular }}</div>
            </div>
        </div>
    </div>
</body>
</html>

