<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pedido de Venta {{ $pedidoVenta->folio }}</title>
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
        }
        @media print {
            .watermark { color: rgba(220, 38, 38, 0.25) !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }
        .header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #0f5132; padding-bottom: 12px; margin-bottom: 15px; }
        .header-logo img { height: 55px; width: auto; }
        .header-right .folio { font-size: 18px; font-weight: 700; color: #0f5132; }
        h1 { text-align: center; font-size: 20px; letter-spacing: 2px; margin: 15px 0; color: #0f5132; }
        .info-row { display: flex; justify-content: space-between; margin: 8px 0; font-size: 12px; }
        .info-row span { font-weight: bold; }
        table { width: 100%; border-collapse: collapse; margin: 15px 0; font-size: 12px; }
        th { background: #0f5132; color: white; padding: 8px 6px; text-align: left; font-size: 11px; text-transform: uppercase; }
        td { padding: 8px 6px; border-bottom: 1px solid #ddd; }
        .text-right { text-align: right; }
        .totales { margin-top: 20px; text-align: right; }
        .totales .total { font-size: 18px; font-weight: 700; color: #0f5132; }
        @media print { body { padding: 0; } .page { border: none; box-shadow: none; } }
    </style>
</head>
<body>
    <div class="page">
        @if($pedidoVenta->estatus === 'cancelada')
        <div class="watermark">CANCELADA</div>
        @endif
        <div class="header">
            <div class="header-logo">
                <img src="{{ asset('grajalsin-removebg-preview.png') }}" alt="Grajalsin">
            </div>
            <div class="header-right">
                <div class="folio">{{ $pedidoVenta->folio }}</div>
                <p style="margin-top: 8px;">FECHA: {{ $pedidoVenta->fecha->format('d/m/Y') }}</p>
            </div>
        </div>

        <h1>PEDIDO DE VENTA</h1>

        <div class="info-row">
            <span>CLIENTE:</span> {{ $pedidoVenta->cliente->nombre }}
        </div>
        <div class="info-row">
            @if($pedidoVenta->producto && $pedidoVenta->producto->tipo_producto === 'costal')
                <span>CANTIDAD DE COSTALES:</span> {{ number_format($pedidoVenta->toneladas, 0) }}
            @else
                <span>TONELADAS:</span> {{ number_format($pedidoVenta->toneladas, 2) }}
            @endif
            <span>PRECIO VENTA:</span> ${{ number_format($pedidoVenta->precio_venta, 2) }}
        </div>
        <div class="info-row">
            <span>TARIFA FLETE:</span> ${{ number_format($pedidoVenta->tarifa_flete, 2) }}
            <span>FECHA ENTREGA:</span> {{ $pedidoVenta->fecha_entrega->format('d/m/Y') }}
        </div>
        <div class="info-row">
            <span>BODEGA DE CARGA:</span> {{ $pedidoVenta->bodega->nombre }}{{ $pedidoVenta->bodega->ubicacion ? ' - ' . $pedidoVenta->bodega->ubicacion : '' }}
        </div>
        <div class="info-row">
            <span>DESTINO:</span> {{ $pedidoVenta->destino->nombre }}{{ $pedidoVenta->destino->estado ? ' - ' . $pedidoVenta->destino->estado : '' }}
        </div>
        <div class="info-row">
            <span>TIPO DE COSTAL:</span> {{ $pedidoVenta->producto?->nombre ?? '—' }}
        </div>

        <table>
            <thead>
                <tr>
                    <th>Concepto</th>
                    <th class="text-right">Importe</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Subtotal (
                        @if($pedidoVenta->producto && $pedidoVenta->producto->tipo_producto === 'costal')
                            {{ number_format($pedidoVenta->toneladas, 0) }} costales
                        @else
                            {{ number_format($pedidoVenta->toneladas, 2) }} ton
                        @endif
                        × ${{ number_format($pedidoVenta->precio_venta, 2) }})
                    </td>
                    <td class="text-right">${{ number_format($pedidoVenta->importe_subtotal, 2) }}</td>
                </tr>
                <tr>
                    <td>Tarifa de flete <span style="font-size: 10px; color: #666;">(pago directo a línea de transporte)</span></td>
                    <td class="text-right">${{ number_format($pedidoVenta->tarifa_flete, 2) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="totales">
            <p class="total">TOTAL A PAGAR A GRAJALSIN: ${{ number_format($pedidoVenta->importe_total, 2) }}</p>
        </div>

        @if($pedidoVenta->notas)
        <p style="margin-top: 15px; font-size: 11px; color: #555;">Notas: {{ $pedidoVenta->notas }}</p>
        @endif
    </div>
</body>
</html>
