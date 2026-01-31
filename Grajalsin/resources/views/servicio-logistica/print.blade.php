@php
    $servicio = $servicioLogistica;
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DATOS DE CARGA - {{ $servicio->folio }}</title>
    <style>
        * { 
            box-sizing: border-box; 
            font-family: 'Arial', sans-serif; 
            margin: 0;
            padding: 0;
        }
        body { 
            margin: 0; 
            padding: 20px; 
            background: #ffffff; 
        }
        .page {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            border: 2px solid #000;
            padding: 0;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 2px solid #000;
            background: #fff;
        }
        .header-left {
            flex: 1;
        }
        .header-title {
            font-size: 28px;
            font-weight: bold;
            color: #000;
            margin-bottom: 5px;
        }
        .header-subtitle {
            font-size: 16px;
            color: #000;
            text-decoration: underline;
        }
        .header-logo {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0f0f0;
            border: 1px solid #ccc;
        }
        .logo-text {
            font-size: 10px;
            text-align: center;
            color: #000;
            font-weight: bold;
        }
        .content {
            display: flex;
            min-height: 600px;
        }
        .left-column {
            width: 60%;
            padding: 20px;
            border-right: 2px solid #000;
            background: #fff;
        }
        .right-column {
            width: 40%;
            padding: 20px;
            background: #fff;
        }
        .field-row {
            display: flex;
            margin-bottom: 12px;
            align-items: baseline;
        }
        .field-label {
            font-weight: bold;
            min-width: 150px;
            margin-right: 10px;
        }
        .field-value {
            flex: 1;
            border-bottom: 1px dotted #000;
            min-height: 20px;
            padding-bottom: 2px;
        }
        .highlight-section {
            background: #ffd6e8;
            padding: 15px;
            margin: 15px 0;
            border: 1px solid #ffb3d9;
        }
        .internal-info {
            margin-top: 30px;
        }
        .internal-title {
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
        .internal-box {
            background: #ffd6e8;
            padding: 15px;
            margin-top: 10px;
            border: 1px solid #ffb3d9;
        }
        .folio-box {
            background: #ff00ff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            font-size: 16px;
            margin-top: 20px;
        }
        .clave-box {
            background: #ff00ff;
            height: 40px;
            margin-bottom: 10px;
        }
        @media print {
            body { padding: 0; }
            .page { border: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="page">
        <div class="header">
            <div class="header-left">
                <div class="header-title">DATOS DE CARGA</div>
                <div class="header-subtitle">CATTALOGISTIC</div>
            </div>
            <div class="header-logo">
                <div class="logo-text">
                    CATTA<br>
                    LOGISTIC
                </div>
            </div>
        </div>

        <div class="content">
            <div class="left-column">
                <!-- Datos del Operador -->
                <div class="field-row">
                    <span class="field-label">Operador:</span>
                    <span class="field-value">{{ $servicio->operador_nombre ?? ($servicio->chofer->nombre ?? '') }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">No. Celular:</span>
                    <span class="field-value">{{ $servicio->operador_celular ?? ($servicio->chofer->telefono ?? '') }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Numero de Licencia:</span>
                    <span class="field-value">{{ $servicio->operador_licencia_numero ?? ($servicio->chofer->licencia_numero ?? '') }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Expediente Medico:</span>
                    <span class="field-value">{{ $servicio->operador_expediente_medico ?? ($servicio->chofer->expediente_medico_numero ?? '') }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Curp y/o RFC:</span>
                    <span class="field-value">{{ $servicio->operador_curp_rfc ?? ($servicio->chofer->curp ?? '') }}</span>
                </div>
                
                <!-- Datos del Vehículo -->
                <div class="field-row">
                    <span class="field-label">Placa de tractor:</span>
                    <span class="field-value">{{ $servicio->placa_tractor ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Placa del remolque:</span>
                    <span class="field-value">{{ $servicio->placa_remolque ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Modelo y color:</span>
                    <span class="field-value">{{ $servicio->modelo_color ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Poliza / Compañia:</span>
                    <span class="field-value">{{ $servicio->poliza_compania ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Destino de la Carga:</span>
                    <span class="field-value">{{ $servicio->destino_carga ?? ($servicio->destino->nombre ?? '') }}</span>
                </div>

                <!-- Sección destacada -->
                <div class="highlight-section">
                    <div class="field-row">
                        <span class="field-label">Tarifa:</span>
                        <span class="field-value">${{ number_format($servicio->tarifa ?? 0, 2) }}</span>
                    </div>
                    <div class="field-row">
                        <span class="field-label">Cliente / Empresa:</span>
                        <span class="field-value">{{ $servicio->cliente_empresa ?? ($servicio->cliente->nombre ?? '') }}</span>
                    </div>
                </div>

                <!-- Información adicional -->
                <div class="field-row">
                    <span class="field-label">Fecha:</span>
                    <span class="field-value">{{ $servicio->fecha ? $servicio->fecha->format('d/m/Y') : '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Coordinador:</span>
                    <span class="field-value">{{ $servicio->coordinador_nombre ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Numero:</span>
                    <span class="field-value">{{ $servicio->coordinador_numero ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Linea:</span>
                    <span class="field-value">{{ $servicio->lineaCarga->nombre ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Cliente:</span>
                    <span class="field-value">{{ $servicio->cliente->nombre ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Criba:</span>
                    <span class="field-value">{{ $servicio->criba ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Bodega:</span>
                    <span class="field-value">{{ $servicio->bodega ?? '' }}</span>
                </div>
                <div class="field-row">
                    <span class="field-label">Fecha:</span>
                    <span class="field-value">{{ $servicio->fecha_carga ? $servicio->fecha_carga->format('d/m/Y') : '' }}</span>
                </div>
            </div>

            <div class="right-column">
                <div class="internal-info">
                    <div class="internal-title">INFORMACION INTERNA</div>
                    <div class="clave-box"></div>
                    <div class="field-row">
                        <span class="field-label">CLAVE.</span>
                        <span class="field-value">{{ $servicio->clave_interna ?? '' }}</span>
                    </div>
                    <div class="folio-box">
                        FOLIO: {{ $servicio->folio }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

