<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            line-height: 1.3;
            margin: 0;
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        td, th {
            padding: 4px;
            vertical-align: top;
        }
        .border-all {
            border: 2px solid #000;
        }
        .border-right {
            border-right: 2px solid #000;
        }
        .border-bottom {
            border-bottom: 2px solid #000;
        }
        .text-bold {
            font-weight: bold;
        }
        .text-center {
            text-align: center;
        }
        .bg-gray {
            background-color: #e0e0e0;
        }
        .page-break {
            page-break-after: always;
        }
        .section-title {
            font-weight: bold;
            padding: 5px;
            background-color: #f0f0f0;
            border: 2px solid #000;
            margin-top: 5px;
            margin-bottom: 5px;
        }
        .checkbox {
            width: 12px;
            height: 12px;
            border: 2px solid #000;
            display: inline-block;
            margin-right: 5px;
            vertical-align: middle;
        }
        .checkbox.checked {
            background-color: #000;
        }
        img.signature {
            max-width: 150px;
            height: auto;
        }
        img.detail-image {
            max-width: 100%;
            max-height: 250px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    @include('pdf.particulas-magneticas-header', ['date' => $fecha])

    <!-- PÁGINA 1 -->
    
    <!-- Tabla 1: Información General -->
    <table class="border-all">
        <tr>
            <td class="border-right border-bottom text-bold" style="width: 15%;">INFORME No.</td>
            <td class="border-right border-bottom" style="width: 18%;">{{ $informe_no }}</td>
            <td class="border-right border-bottom text-bold" style="width: 10%;">FECHA:</td>
            <td class="border-right border-bottom" style="width: 18%;">{{ $fecha }}</td>
            <td class="border-right border-bottom text-bold" style="width: 10%;">G.O. No.</td>
            <td class="border-bottom" style="width: 29%;">{{ $go_no }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">CLIENTE:</td>
            <td colspan="5" class="border-bottom">{{ $cliente }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">PROYECTO:</td>
            <td colspan="5" class="border-bottom">{{ $proyecto }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">SITIO DE INSPECCIÓN:</td>
            <td colspan="3" class="border-right border-bottom">{{ $sitio_inspeccion }}</td>
            <td class="border-right border-bottom text-bold">CIUDAD:</td>
            <td class="border-bottom">{{ $ciudad }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">ESPECIFICACIÓN (NORMA):</td>
            <td colspan="3" class="border-right border-bottom">{{ $especificacion }}</td>
            <td class="border-right border-bottom text-bold">GERENCIA:</td>
            <td class="border-bottom">{{ $gerencia }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">PIEZA A INSPECCIONAR:</td>
            <td colspan="5" class="border-bottom">{{ $pieza_inspeccionar }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">MATERIAL:</td>
            <td class="border-right border-bottom">{{ $material }}</td>
            <td class="border-right border-bottom text-bold">DIMENSIONES:</td>
            <td colspan="3" class="border-bottom">{{ $dimensiones }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">ÁREA INSPECCIONADA:</td>
            <td colspan="5" class="border-bottom">{{ $area_inspeccionada }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">ACABADO SUPERFICIAL:</td>
            <td colspan="2" class="border-right border-bottom">{{ $acabado_superficial }}</td>
            <td class="border-right border-bottom text-bold">TEMP. DE LA PIEZA:</td>
            <td colspan="2" class="border-bottom">{{ $temperatura_pieza }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">HUMEDAD RELATIVA:</td>
            <td colspan="5" class="border-bottom">{{ $humedad_relativa }}</td>
        </tr>
        <tr>
            <td class="border-right text-bold">INSTRUMENTO DE MEDICIÓN:</td>
            <td class="border-right">{{ $instrumento_medicion }}</td>
            <td class="border-right text-bold">CÓD. METROLÓGICO:</td>
            <td class="border-right">{{ $cod_metrologico }}</td>
            <td class="border-right text-bold">FECHA CALIBRACIÓN:</td>
            <td>{{ $fecha_calibracion }}</td>
        </tr>
    </table>

    <!-- Tabla 2: Especificación de Materiales -->
    <table class="border-all">
        <thead>
            <tr class="bg-gray">
                <th colspan="5" class="border-bottom text-center text-bold" style="padding: 5px;">ESPECIFICACIÓN DE LOS MATERIALES</th>
            </tr>
            <tr class="bg-gray">
                <th class="border-right border-bottom text-center text-bold" style="width: 20%;">TIPO DE MATERIALES</th>
                <th class="border-right border-bottom text-center text-bold" style="width: 20%;">APL.</th>
                <th class="border-right border-bottom text-center text-bold" style="width: 20%;">FABRICANTE</th>
                <th class="border-right border-bottom text-center text-bold" style="width: 20%;">REF. COMERCIAL</th>
                <th class="border-bottom text-center text-bold" style="width: 20%;">LOTE No</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border-right border-bottom text-bold">LIMPIADOR</td>
                <td class="border-right border-bottom">{{ $limpiador_apl }}</td>
                <td class="border-right border-bottom">{{ $limpiador_fabricante }}</td>
                <td class="border-right border-bottom">{{ $limpiador_ref_comercial }}</td>
                <td class="border-bottom">{{ $limpiador_lote }}</td>
            </tr>
            <tr>
                <td class="border-right border-bottom text-bold">PARTÍCULAS MAGNÉTICAS</td>
                <td class="border-right border-bottom">{{ $particulas_apl }}</td>
                <td class="border-right border-bottom">{{ $particulas_fabricante }}</td>
                <td class="border-right border-bottom">{{ $particulas_ref_comercial }}</td>
                <td class="border-bottom">{{ $particulas_lote }}</td>
            </tr>
            <tr>
                <td class="border-right text-bold">PINTURA DE CONTRASTE</td>
                <td class="border-right">{{ $pintura_apl }}</td>
                <td class="border-right">{{ $pintura_fabricante }}</td>
                <td class="border-right">{{ $pintura_ref_comercial }}</td>
                <td>{{ $pintura_lote }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tabla 3: Condiciones en la Inspección -->
    <div class="section-title">CONDICIONES EN LA INSPECCIÓN:</div>
    
    <table class="border-all">
        <tr class="bg-gray">
            <td colspan="4" class="border-bottom text-bold" style="padding: 5px;">1. TÉCNICA DE MAGNETIZACIÓN</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold" style="width: 20%;">TIPO DE EQUIPO:</td>
            <td class="border-right border-bottom" style="width: 30%;">{{ $tipo_equipo }}</td>
            <td class="border-right border-bottom text-bold" style="width: 20%;">MARCA:</td>
            <td class="border-bottom" style="width: 30%;">{{ $marca_equipo }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">MODELO:</td>
            <td class="border-right border-bottom">{{ $modelo_equipo }}</td>
            <td class="border-right border-bottom text-bold">CÓD. METROLÓGICO:</td>
            <td class="border-bottom">{{ $cod_metrologico_equipo }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">FECHA DE CALIBRACIÓN:</td>
            <td colspan="3" class="border-bottom">{{ $fecha_calibracion_equipo }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">TIPO DE MAGNETIZACIÓN:</td>
            <td colspan="3" class="border-bottom">
                @php
                    $tipoMagnetizacion = is_array($tipo_magnetizacion) ? $tipo_magnetizacion : (is_string($tipo_magnetizacion) ? json_decode($tipo_magnetizacion, true) ?? [] : []);
                @endphp
                <span class="checkbox {{ in_array('LONGITUDINAL', $tipoMagnetizacion) ? 'checked' : '' }}"></span> LONGITUDINAL
                <span class="checkbox {{ in_array('CIRCUNFERENCIAL', $tipoMagnetizacion) ? 'checked' : '' }}"></span> CIRCUNFERENCIAL
                <span class="checkbox {{ in_array('MULTIDIRECCIONAL', $tipoMagnetizacion) ? 'checked' : '' }}"></span> MULTIDIRECCIONAL
            </td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">TIPO DE CORRIENTE:</td>
            <td colspan="3" class="border-bottom">
                @php
                    $tipoCorriente = is_array($tipo_corriente) ? $tipo_corriente : (is_string($tipo_corriente) ? json_decode($tipo_corriente, true) ?? [] : []);
                @endphp
                <span class="checkbox {{ in_array('CC', $tipoCorriente) ? 'checked' : '' }}"></span> CC
                <span class="checkbox {{ in_array('CA', $tipoCorriente) ? 'checked' : '' }}"></span> CA
            </td>
        </tr>
        <tr>
            <td class="border-right text-bold">AMPERAJE:</td>
            <td colspan="3">{{ $amperaje }}</td>
        </tr>
    </table>

    <table class="border-all" style="margin-top: 10px;">
        <tr class="bg-gray">
            <td colspan="4" class="border-bottom text-bold" style="padding: 5px;">2. ESPECIFICACIONES GENERALES</td>
        </tr>
        <tr>
            <td colspan="4" class="border-bottom" style="padding: 5px;">
                <strong>CLASE DE PARTÍCULA MAGNÉTICA:</strong>
                @php
                    $claseParticula = is_array($clase_particula) ? $clase_particula : (is_string($clase_particula) ? json_decode($clase_particula, true) ?? [] : []);
                @endphp
                <span class="checkbox {{ in_array('P. M. SECAS', $claseParticula) ? 'checked' : '' }}"></span> P. M. SECAS
                <span class="checkbox {{ in_array('P. M. HÚMEDAS', $claseParticula) ? 'checked' : '' }}"></span> P. M. HÚMEDAS
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-bottom" style="padding: 5px;">
                <strong>TIPO DE PARTÍCULAS:</strong>
                @php
                    $tipoParticulas = is_array($tipo_particulas) ? $tipo_particulas : (is_string($tipo_particulas) ? json_decode($tipo_particulas, true) ?? [] : []);
                @endphp
                <span class="checkbox {{ in_array('FLUORESCENTES', $tipoParticulas) ? 'checked' : '' }}"></span> FLUORESCENTES
                <span class="checkbox {{ in_array('CONTRASTANTES', $tipoParticulas) ? 'checked' : '' }}"></span> CONTRASTANTES
                <span class="checkbox {{ in_array('COLOR', $tipoParticulas) ? 'checked' : '' }}"></span> COLOR
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-bottom" style="padding: 5px;">
                <strong>SECUENCIA DE APLICACIÓN DE LAS PARTÍCULAS MAGNÉTICAS:</strong>
                @php
                    $secuenciaAplicacion = is_array($secuencia_aplicacion) ? $secuencia_aplicacion : (is_string($secuencia_aplicacion) ? json_decode($secuencia_aplicacion, true) ?? [] : []);
                @endphp
                <span class="checkbox {{ in_array('CONTINUA', $secuenciaAplicacion) ? 'checked' : '' }}"></span> CONTINUA
                <span class="checkbox {{ in_array('RESIDUAL', $secuenciaAplicacion) ? 'checked' : '' }}"></span> RESIDUAL
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-bottom" style="padding: 5px;">
                <strong>MODO DE APLICACIÓN:</strong>
                @php
                    $modoAplicacion = is_array($modo_aplicacion) ? $modo_aplicacion : (is_string($modo_aplicacion) ? json_decode($modo_aplicacion, true) ?? [] : []);
                @endphp
                <span class="checkbox {{ in_array('VÍA SECA', $modoAplicacion) ? 'checked' : '' }}"></span> VÍA SECA
                <span class="checkbox {{ in_array('VÍA HÚMEDA', $modoAplicacion) ? 'checked' : '' }}"></span> VÍA HÚMEDA
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-bottom" style="padding: 5px;">
                <strong>TIPO DE ILUMINACIÓN:</strong>
                @php
                    $tipoIluminacion = is_array($tipo_iluminacion) ? $tipo_iluminacion : (is_string($tipo_iluminacion) ? json_decode($tipo_iluminacion, true) ?? [] : []);
                @endphp
                <span class="checkbox {{ in_array('NATURAL', $tipoIluminacion) ? 'checked' : '' }}"></span> NATURAL
                <span class="checkbox {{ in_array('BLANCA ARTIFICIAL', $tipoIluminacion) ? 'checked' : '' }}"></span> BLANCA ARTIFICIAL
                <span class="checkbox {{ in_array('ULTRAVIOLETA', $tipoIluminacion) ? 'checked' : '' }}"></span> ULTRAVIOLETA
            </td>
        </tr>
        <tr>
            <td colspan="4" class="border-bottom" style="padding: 5px;">
                <strong>DESMAGNETIZACIÓN:</strong>
                <span class="checkbox {{ $desmagnetizacion == 'SÍ' ? 'checked' : '' }}"></span> SÍ
                <span class="checkbox {{ $desmagnetizacion == 'NO' ? 'checked' : '' }}"></span> NO
            </td>
        </tr>
        <tr>
            <td class="border-right text-bold" style="width: 35%;">CAMPO RESIDUAL FINAL:</td>
            <td class="border-right" style="width: 15%;">{{ $campo_residual_final }}</td>
            <td class="border-right text-bold" style="width: 35%;">TEMPERATURA DE SUPERFICIE:</td>
            <td style="width: 15%;">{{ $temperatura_superficie }}</td>
        </tr>
    </table>

    <table class="border-all" style="margin-top: 5px;">
        <tr>
            <td class="text-bold" style="width: 35%;">CONCENTRACIÓN DEL BAÑO:</td>
            <td>{{ $concentracion_bano }}</td>
        </tr>
    </table>

    <!-- Tabla 4: Croquis (Discontinuidades) -->
    <table class="border-all" style="margin-top: 10px;">
        <thead>
            <tr class="bg-gray">
                <th colspan="5" class="border-bottom text-center text-bold" style="padding: 5px;">3. CROQUIS (Ver detalle en la Pág. 2)</th>
            </tr>
            <tr class="bg-gray">
                <th class="border-right border-bottom text-center text-bold" style="width: 5%;">ITEM</th>
                <th class="border-right border-bottom text-center text-bold" style="width: 35%;">DESCRIPCIÓN DE LA DISCONTINUIDAD</th>
                <th class="border-right border-bottom text-center text-bold" style="width: 15%;">FORMA<br>(LINEAL/REDONDA)</th>
                <th class="border-right border-bottom text-center text-bold" style="width: 20%;">DIMENSIÓN</th>
                <th class="border-bottom text-center text-bold" style="width: 25%;">EVALUACIÓN<br>(ACEPTADA/RECHAZADA)</th>
            </tr>
        </thead>
        <tbody>
            @php
                $discontinuidadesArray = is_string($discontinuidades) ? json_decode($discontinuidades, true) : $discontinuidades;
            @endphp
            @foreach(range(1, 6) as $index)
                @php
                    $item = isset($discontinuidadesArray[$index - 1]) ? $discontinuidadesArray[$index - 1] : null;
                @endphp
                <tr>
                    <td class="border-right {{ $index < 6 ? 'border-bottom' : '' }} text-center text-bold">{{ $index }}</td>
                    <td class="border-right {{ $index < 6 ? 'border-bottom' : '' }}">{{ $item['descripcion'] ?? '' }}</td>
                    <td class="border-right {{ $index < 6 ? 'border-bottom' : '' }} text-center">{{ $item['forma'] ?? '' }}</td>
                    <td class="border-right {{ $index < 6 ? 'border-bottom' : '' }} text-center">{{ $item['dimension'] ?? '' }}</td>
                    <td class="{{ $index < 6 ? 'border-bottom' : '' }} text-center">{{ $item['evaluacion'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- SALTO DE PÁGINA -->
    <div class="page-break"></div>

    <!-- PÁGINA 2 -->
    @include('pdf.particulas-magneticas-header', ['date' => $fecha])

    <!-- Detalle de la Pieza -->
    <div class="section-title">DETALLE DE LA PIEZA:</div>
    <div style="border: 2px solid #000; padding: 10px; text-align: center; min-height: 300px;">
        @if(!empty($detalle_pieza))
            @if(str_starts_with($detalle_pieza, 'data:image'))
                <img src="{{ $detalle_pieza }}" alt="Detalle de la pieza" class="detail-image">
            @else
                {!! $detalle_pieza !!}
            @endif
        @else
            <p style="color: #999; padding: 50px;">No se ha cargado ninguna imagen</p>
        @endif
    </div>

    <!-- Observaciones -->
    <div class="section-title" style="margin-top: 10px;">OBSERVACIONES:</div>
    <div style="border: 2px solid #000; padding: 10px; min-height: 80px;">
        {!! $observaciones ?? '' !!}
    </div>

    <!-- Resultado Final -->
    <table class="border-all" style="margin-top: 10px;">
        <tr>
            <td class="text-bold" style="width: 40%; padding: 8px;">RESULTADO FINAL DE LA PRUEBA:</td>
            <td style="padding: 8px;">
                <span class="checkbox {{ $resultado_final == 'SATISFACTORIA' ? 'checked' : '' }}"></span> SATISFACTORIA
                &nbsp;&nbsp;&nbsp;
                <span class="checkbox {{ $resultado_final == 'NO SATISFACTORIA' ? 'checked' : '' }}"></span> NO SATISFACTORIA
            </td>
        </tr>
    </table>

    @include('pdf.partials.firmas-section')
</body>
</html>
