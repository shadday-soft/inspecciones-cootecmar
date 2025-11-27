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
        .border-bottom-thin {
            border-bottom: 1px solid #000;
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
        img.esquema-image {
            max-width: 100%;
            max-height: 350px;
            object-fit: contain;
        }
    </style>
</head>
<body>
    @include('pdf.ultrasonido-header')

    <!-- PÁGINA 1 -->
    
    <!-- Tabla 1: Información General -->
    <table class="border-all">
        <tr>
            <td class="border-right border-bottom text-bold" style="width: 20%;">Reporte (Report) No.:</td>
            <td class="border-right border-bottom" style="width: 30%;">{{ $reporte_no }}</td>
            <td class="border-right border-bottom text-bold" style="width: 20%;">Fecha (Date):</td>
            <td class="border-right border-bottom" style="width: 10%;">{{ $fecha }}</td>
            <td class="border-right border-bottom text-bold" style="width: 10%;">G.O. No:</td>
            <td class="border-bottom" style="width: 10%;">{{ $go_no }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">Cliente (Customer):</td>
            <td colspan="5" class="border-bottom">{{ $cliente }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">Lugar De Inspección<br>(Inspection Place):</td>
            <td colspan="3" class="border-right border-bottom">{{ $lugar_inspeccion }}</td>
            <td class="border-right border-bottom text-bold">Proyecto<br>(Project):</td>
            <td class="border-bottom">{{ $proyecto }}</td>
        </tr>
        <tr>
            <td class="border-right border-bottom text-bold">Especificación<br>(Standard):</td>
            <td colspan="3" class="border-right border-bottom">{{ $especificacion }}</td>
            <td class="border-right border-bottom text-bold">Gerencia<br>(Management):</td>
            <td class="border-bottom">{{ $gerencia }}</td>
        </tr>
        <tr>
            <td class="border-right text-bold">Pieza (Piece):</td>
            <td colspan="5">{{ $pieza }}</td>
        </tr>
    </table>

    <!-- Tabla 2: Datos Componente -->
    <table class="border-all">
        <thead>
            <tr class="bg-gray">
                <th colspan="4" class="border-bottom text-center text-bold" style="padding: 5px;">DATOS COMPONENTE (COMPONENT DATA)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border-right border-bottom text-bold" style="width: 25%;">Zona Inspeccionada:<br><small>(Inspectioned Zone):</small></td>
                <td class="border-right border-bottom" style="width: 25%;">{{ $zona_inspeccionada }}</td>
                <td class="border-right border-bottom text-bold" style="width: 25%;">Dimensiones:<br><small>(Dimensions):</small></td>
                <td class="border-bottom" style="width: 25%;">{{ $dimensiones }}</td>
            </tr>
            <tr>
                <td class="border-right border-bottom text-bold">Especificación Del Material:<br><small>(Material Especification):</small></td>
                <td class="border-right border-bottom">{{ $especificacion_material }}</td>
                <td class="border-right border-bottom text-bold">Acabado Superficial:<br><small>(Surface Finish):</small></td>
                <td class="border-bottom">{{ $acabado_superficial }}</td>
            </tr>
            <tr>
                <td class="border-right border-bottom text-bold">Área De Inspección:<br><small>(Inspection Area):</small></td>
                <td class="border-right border-bottom">{{ $area_inspeccion }}</td>
                <td class="border-right border-bottom text-bold">Temperatura:<br><small>(Temperature):</small></td>
                <td class="border-bottom">{{ $temperatura }}</td>
            </tr>
            <tr>
                <td class="border-right text-bold">Proceso De Fabricación:<br><small>(Fabrication Process):</small></td>
                <td class="border-right">{{ $proceso_fabricacion }}</td>
                <td class="border-right text-bold">Espesor Del Material:<br><small>(Material Thickness):</small></td>
                <td>{{ $espesor_material }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Tabla 3: Condiciones de Inspección -->
    <table class="border-all">
        <thead>
            <tr class="bg-gray">
                <th colspan="4" class="border-bottom text-center text-bold" style="padding: 5px;">CONDICIONES DE INSPECCIÓN (INSPECTION CONDITION)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="border-right border-bottom text-bold" style="width: 25%;">Tipo De Representación:<br><small>(Representation Type):</small></td>
                <td class="border-right border-bottom" style="width: 25%;">{{ $tipo_representacion }}</td>
                <td class="border-right border-bottom text-bold" style="width: 25%;">Método De Inspección:<br><small>(Inspection Method):</small></td>
                <td class="border-bottom" style="width: 25%;">{{ $metodo_inspeccion }}</td>
            </tr>
            <tr>
                <td class="border-right border-bottom text-bold">Técnica Usada:<br><small>(Technique):</small></td>
                <td class="border-right border-bottom">{{ $tecnica_usada }}</td>
                <td class="border-right border-bottom text-bold">Acoplante:<br><small>(Couplant):</small></td>
                <td class="border-bottom">{{ $acoplante }}</td>
            </tr>
            <tr>
                <td class="border-right border-bottom text-bold">Procedimiento:<br><small>(Procedure):</small></td>
                <td class="border-right border-bottom">{{ $procedimiento }}</td>
                <td class="border-right border-bottom text-bold">Bloque De Calibración:<br><small>(Calibration Block):</small></td>
                <td class="border-bottom">{{ $bloque_calibracion }}</td>
            </tr>
            <tr>
                <td class="border-right border-bottom text-bold">Equipo:<br><small>(Equipment):</small></td>
                <td class="border-right border-bottom">{{ $equipo }}</td>
                <td class="border-right border-bottom text-bold">Frecuencia:<br><small>(Frequency):</small></td>
                <td class="border-bottom">{{ $frecuencia }}</td>
            </tr>
            <tr>
                <td class="border-right border-bottom text-bold">Palpador:<br><small>(Unit Search):</small></td>
                <td class="border-right border-bottom">{{ $palpador }}</td>
                <td class="border-right border-bottom text-bold">Método De Calibración:<br><small>(Calibration Method):</small></td>
                <td class="border-bottom">{{ $metodo_calibracion }}</td>
            </tr>
            <tr>
                <td class="border-right border-bottom text-bold">Ángulo:<br><small>(Angle):</small></td>
                <td class="border-right border-bottom">{{ $angulo }}</td>
                <td class="border-right border-bottom text-bold">Criterios De Aceptación:<br><small>(Acceptance Level):</small></td>
                <td class="border-bottom">{{ $criterios_aceptacion }}</td>
            </tr>
            <tr>
                <td class="border-right text-bold">Código Metrológico:<br><small>(Metrological Code):</small></td>
                <td class="border-right">{{ $codigo_metrologico }}</td>
                <td class="border-right text-bold">Fecha De Calibración:<br><small>(Calibration Date):</small></td>
                <td>{{ $fecha_calibracion }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Esquemas -->
    <div class="section-title">ESQUEMAS (SKETCHS):</div>
    <div style="border: 2px solid #000; padding: 10px; text-align: center; min-height: 300px;">
        @if(!empty($esquemas))
            @if(str_starts_with($esquemas, 'data:image'))
                <img src="{{ $esquemas }}" alt="Esquemas" class="esquema-image">
            @else
                {!! $esquemas !!}
            @endif
        @else
            <p style="color: #999; padding: 50px;">No se ha cargado ninguna imagen</p>
        @endif
    </div>

    <!-- SALTO DE PÁGINA -->
    <div class="page-break"></div>

    <!-- PÁGINA 2 -->
    @include('pdf.ultrasonido-header')

    <!-- Tabla de Descripción del Defecto -->
    <table class="border-all" style="font-size: 7px;">
        <thead>
            <tr class="bg-gray">
                <th colspan="14" class="border-bottom text-center text-bold" style="padding: 5px; font-size: 9px;">DESCRIPCIÓN DEL DEFECTO (FLAW CHARACTERIZATION)</th>
            </tr>
            <tr class="bg-gray">
                <th rowspan="2" class="border-right border-bottom text-center text-bold" style="width: 4%;">No.<br>ITEM</th>
                <th rowspan="2" class="border-right border-bottom text-center text-bold" style="width: 6%;">ÁNGULO<br>INDICACIÓN<br>(INDICATION)<br>(ANGLE)</th>
                <th rowspan="2" class="border-right border-bottom text-center text-bold" style="width: 7%;">ANCHO<br>CARA<br>DIÁMETRO<br>(AXGE)<br>(FACE<br>WIDTH<br>DIAMETER)<br>mm</th>
                <th rowspan="2" class="border-right border-bottom text-center text-bold" style="width: 7%;">PIERNA<br>PIES<br>(FEET<br>LEG)<br>mm</th>
                <th colspan="4" class="border-right border-bottom text-center text-bold" style="width: 16%;">DECIBELES (INCHES) dB<br>(AWS)</th>
                <th colspan="3" class="border-right border-bottom text-center text-bold" style="width: 18%;">INDICACIÓN<br>(INVOCATION)</th>
                <th colspan="2" class="border-right border-bottom text-center text-bold" style="width: 12%;">DISTANCIA<br>(LOCATION)</th>
                <th rowspan="2" class="border-bottom text-center text-bold" style="width: 30%;">COMENTARIOS<br>(COMMENTARIES)</th>
            </tr>
            <tr class="bg-gray">
                <th class="border-right border-bottom text-center">a</th>
                <th class="border-right border-bottom text-center">b</th>
                <th class="border-right border-bottom text-center">c</th>
                <th class="border-right border-bottom text-center">d</th>
                <th class="border-right border-bottom text-center">PA<br>mm</th>
                <th class="border-right border-bottom text-center">SA<br>mm</th>
                <th class="border-right border-bottom text-center">DA<br>mm</th>
                <th class="border-right border-bottom text-center">X<br>(mm)</th>
                <th class="border-right border-bottom text-center">Y</th>
            </tr>
        </thead>
        <tbody>
            @php
                $defectosArray = is_string($defectos) ? json_decode($defectos, true) : $defectos;
            @endphp
            @foreach(range(1, 10) as $index)
                @php
                    $item = isset($defectosArray[$index - 1]) ? $defectosArray[$index - 1] : null;
                @endphp
                <tr>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center text-bold">{{ $index }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['angulo_indicacion'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['ancho_cara'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['pierna_pies'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['decibeles_a'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['decibeles_b'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['decibeles_c'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['decibeles_d'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['indicacion_pa'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['indicacion_sa'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['indicacion_da'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['distancia_x'] ?? '' }}</td>
                    <td class="border-right {{ $index < 10 ? 'border-bottom-thin' : '' }} text-center">{{ $item['distancia_y'] ?? '' }}</td>
                    <td class="{{ $index < 10 ? 'border-bottom-thin' : '' }}">{{ $item['comentarios'] ?? '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Observaciones -->
    <div class="section-title" style="margin-top: 10px;">OBSERVACIONES (OBSERVATIONS):</div>
    <div style="border: 2px solid #000; padding: 10px; min-height: 80px;">
        {!! $observaciones ?? '' !!}
    </div>

    <!-- Convenciones -->
    <div style="border: 2px solid #000; padding: 8px; margin-top: 5px; font-size: 8px;">
        <strong>Convenciones (Conventions):</strong><br>
        <strong>SA:</strong> Distancia De Recorrido Del Sonido (Sweep Distance); <strong>PA:</strong> Longitud Horizontal (Horizontal Position) (RA); <strong>DA:</strong> Profundidad (Depth Position).<br>
        <strong>a:</strong> Indication Level; <strong>b:</strong> Reference Level; <strong>c:</strong> Attenuation Factor; <strong>d:</strong> Indication Rating
    </div>

    <!-- Resultado Final -->
    <table class="border-all" style="margin-top: 10px;">
        <tr>
            <td class="text-bold" style="width: 30%; padding: 8px;">FINAL TEST RESULT:</td>
            <td style="padding: 8px;">
                <span class="checkbox {{ $resultado_final == 'ACEPTADO (ACCEPTED)' ? 'checked' : '' }}"></span> ■ ACEPTADO (ACCEPTED)
                &nbsp;&nbsp;&nbsp;
                <span class="checkbox {{ $resultado_final == 'RECHAZADO (NON ACCEPTED)' ? 'checked' : '' }}"></span> □ RECHAZADO (NON ACCEPTED)
            </td>
        </tr>
    </table>

    @include('pdf.partials.firmas-section')
</body>
</html>
