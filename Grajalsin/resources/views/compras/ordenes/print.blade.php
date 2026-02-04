<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Orden de Compra {{ $ordenCompra->folio }}</title>
    <style>
        * { box-sizing: border-box; font-family: 'Arial Narrow', Arial, sans-serif; margin: 0; padding: 0; }
        body { margin: 0; padding: 20px; background: #ffffff; font-size: 13px; }
        .page { max-width: 800px; margin: 0 auto; border: 2px solid #0f5132; padding: 20px; position: relative; }
        .watermark { 
            position: absolute; 
            top: 50%; 
            left: 50%; 
            transform: translate(-50%, -50%) rotate(-45deg); 
            font-size: 120px; 
            font-weight: 900; 
            color: rgba(220, 38, 38, 0.2); 
            z-index: 1000; 
            pointer-events: none;
            text-transform: uppercase;
            letter-spacing: 15px;
            white-space: nowrap;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        @media print {
            .watermark {
                color: rgba(220, 38, 38, 0.25) !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #0f5132; padding-bottom: 12px; margin-bottom: 15px; }
        .header-logo img { height: 55px; width: auto; }
        .header-logo p { font-size: 11px; color: #666; margin-top: 2px; }
        .header-right { text-align: right; }
        .header-right .folio { font-size: 18px; font-weight: 700; color: #0f5132; }
        h1 { text-align: center; font-size: 20px; letter-spacing: 2px; margin: 15px 0; color: #0f5132; }
        .info-row { display: flex; justify-content: space-between; margin: 8px 0; font-size: 12px; }
        .info-row span { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 12px; }
        th { background: #0f5132; color: white; padding: 8px 6px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px 6px; border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .totales { margin-top: 20px; text-align: right; }
        .totales p { margin: 4px 0; font-size: 13px; }
        .totales .total { font-size: 18px; font-weight: 700; color: #0f5132; }
        .firmas { margin-top: 30px; display: flex; justify-content: space-between; padding-top: 20px; border-top: 2px solid #0f5132; }
        .firma { text-align: center; }
        .firma .label { font-size: 10px; text-transform: uppercase; color: #666; }
        .firma .nombre { font-weight: bold; margin-top: 4px; }
        .notas { margin-top: 15px; font-size: 11px; color: #555; }
        @media print { 
            body { padding: 0; } 
            .page { border: none; box-shadow: none; } 
            .watermark {
                color: rgba(220, 38, 38, 0.25) !important;
            }
        }
    </style>
</head>
<body>
    <div class="page">
        @if($ordenCompra->estatus === 'cancelada')
        <div class="watermark">CANCELADA</div>
        @endif
        <div class="header">
            <div class="header-logo">
                <img src="{{ asset('grajalsin-removebg-preview.png') }}" alt="Grajalsin">
                <p>1000</p>
            </div>
            <div class="header-right">
                <div class="folio">{{ $ordenCompra->folio }}</div>
                <p style="margin-top: 8px;">FECHA: {{ $ordenCompra->fecha->format('d/m/Y') }}</p>
            </div>
        </div>

        <h1>ORDEN DE COMPRA</h1>

        <div class="info-row">
            <span>PROVEEDOR:</span> {{ $ordenCompra->proveedor->nombre }}
        </div>
        <div class="info-row">
            <span>FORMA PAGO:</span> {{ $ordenCompra->forma_pago ?? '—' }}
            <span>USO CFDI:</span> @php
                $uso = $ordenCompra->uso_cfdi ?? null;
                $desc = $uso ? (config('cfdi.usos_cfdi')[$uso] ?? null) : null;
            @endphp
            {{ $uso ? ($desc ? "{$uso} - {$desc}" : $uso) : '—' }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>CANTIDAD</th>
                    <th>DESCRIPCION</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordenCompra->lineas as $linea)
                <tr>
                    <td>{{ $linea->cantidad }} {{ $linea->unidad ?? '' }}</td>
                    <td>{{ $linea->descripcion }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        @if($ordenCompra->notas)
        <p class="notas">{{ $ordenCompra->notas }}</p>
        @endif

        <div class="firmas">
            <div class="firma">
                <div class="label">Elaboró</div>
                <div class="nombre">{{ $ordenCompra->elaborado_por ?? '—' }}</div>
            </div>
            <div class="firma">
                <div class="label">Solicita</div>
                <div class="nombre">{{ $ordenCompra->solicitado_por ?? '—' }}</div>
            </div>
        </div>
    </div>
</body>
</html>
