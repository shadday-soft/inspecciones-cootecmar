<!doctype html>
<html lang='es'>

<head>
    <title>Reporte de Inspección de Hermeticidad por Presión</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Use an absolute path when specifying the CSS so it works in the PDF --}}
    <link href='{{ public_path('css/reports/general.css') }}' rel='stylesheet'>
    <link href='{{ public_path('css/components/header.css') }}' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 15px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        table td,
        table th {
            padding: 5px;
            text-align: left;
            vertical-align: top;
        }

        .form-table td {
            font-size: 9px;
        }

        .header-cell {
            background-color: #f0f0f0;
            font-weight: bold;
        }

        .checkbox-group {
            display: inline-block;
            margin-right: 15px;
        }

        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid black;
            margin-right: 5px;
            vertical-align: middle;
        }

        .checkbox.checked::before {
            content: "X";
            display: block;
            text-align: center;
            font-weight: bold;
            line-height: 12px;
            font-size: 14px;
        }

        .observations-area {
            min-height: 80px;
            border: 1px solid black;
            padding: 5px;
        }

        .signature-section {
            margin-top: 20px;
        }

        .signature-box {
            border-bottom: 1px solid black;
            margin-top: 80px;
            padding-top: 5px;
            text-align: center;
        }

        .signature-row {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .observations-row {
            page-break-after: auto;
        }
    </style>
</head>

<body>
    <header>
        <x-pdf.hermeticidad-header></x-pdf.hermeticidad-header>
    </header>

    <main>
        <table class="form-table">
            <!-- Primera fila: GERENCIA, G.O. No., REGISTRO No., FECHA -->
            <tr>
                <td class="header-cell" style="width: 25%;">GERENCIA: {{ $report->inspection['gerencia'] }}</td>
                <td class="header-cell" style="width: 25%;">G.O. No.:</td>
                <td class="header-cell" style="width: 25%;">REGISTRO No.:</td>
                <td class="header-cell" style="width: 25%;">FECHA : {{ $report->inspection->fecha ?? '' }}</td>
            </tr>

            <!-- Segunda fila: PROYECTO -->
            <tr>
                <td colspan="4" class="header-cell">PROYECTO: {{ $report->inspection->project->name ?? '' }}</td>
            </tr>


            <!-- Tercera fila: TIPO DE PRUEBA -->
            @php
            $tipoPrueba = collect($report->fieldReports)->firstWhere('field', 'tipo_prueba')['value'] ?? '';;
            $montajeDispositivo = collect($report->fieldReports)->firstWhere('field', 'montaje_dispositivo')['value'] ?? '';
            @endphp
            <tr>
                <td class="header-cell">TIPO DE PRUEBA:</td>
                <td colspan="4">
                    <span class="checkbox-group">
                        <span class="checkbox {{ str_contains($tipoPrueba, 'HIDROSTATICA') ? 'checked' : '' }}"></span> HIDROSTÁTICA
                    </span>
                    <span class="checkbox-group">
                        <span class="checkbox {{ str_contains($tipoPrueba, 'NEUMATICA') ? 'checked' : '' }}"></span> NEUMÁTICA
                    </span>
                    <span class="checkbox-group">
                        <span class="checkbox {{ str_contains($tipoPrueba, 'VACIO') ? 'checked' : '' }}"></span> VACÍO
                    </span>
                </td>

            </tr>
            <tr>
                <td class="header-cell">
                    <strong>MONTAJE DEL<br>DISPOSITIVO DE LA<br>PRUEBA.</strong>
                </td>
                <td colspan="4">
                    <table style="border: none; width: 100%;">
                        <tr>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ str_contains($montajeDispositivo, 'Division de Soldadura') ? 'checked' : '' }}"></span>
                                <strong>División de Soldadura</strong>
                            </td>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ str_contains($montajeDispositivo, 'Division de motores|') ? 'checked' : '' }}"></span>
                                <strong>División de Motores</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ str_contains($montajeDispositivo, 'Division de mecanica|') ? 'checked' : '' }}"></span>
                                <strong>División de Mecánica</strong>
                            </td>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ str_contains($montajeDispositivo, 'Casco y Estructura - Maquinaria') ? 'checked' : '' }}"></span>
                                <strong>Casco y Estructura - Maquinaria</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ str_contains($montajeDispositivo, 'Contratista') ? 'checked' : '' }}"></span>
                                <strong>Contratista</strong>
                            </td>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ str_contains($montajeDispositivo, 'Propulsión y Electricidad.') ? 'checked' : '' }}"></span>
                                <strong>Propulsión y Electricidad.</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 2px;" colspan="4">
                                <span class="checkbox {{ str_contains($montajeDispositivo, 'Otro') ? 'checked' : '' }}"></span>
                                <strong>Otro:</strong> {{ str_contains($montajeDispositivo, 'Otro') ? collect($report->fieldReports)->firstWhere('field', 'montaje_otro')['value'] ?? '' : '' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>

            <!-- Cuarta fila: INSPECCIÓN REALIZADA POR -->
            <tr>
                <td colspan="4" class="header-cell">INSPECCIÓN REALIZADA POR: {{ $report->user->name ?? '' }}</td>
            </tr>

            <!-- Quinta fila: Instrumento, Rango, Unidad -->
            <tr>
                <td class="header-cell">INSTRUMENTO DE MEDICIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'instrumento_medicion')['value'] ?? '' }}</td>
                <td class="header-cell">RANGO: {{ collect($report->fieldReports)->firstWhere('field', 'rango')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">UNIDAD DE MEDIDA: {{ collect($report->fieldReports)->firstWhere('field', 'unidad_medida')['value'] ?? '' }}</td>
            </tr>


            <!-- Sexta fila: Código metrológico y fecha de calibración -->
            <tr>
                <td colspan="1" class="header-cell">CÓDIGO METROLÓGICO: {{ collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico')['value'] ?? '' }} </td>
                <td colspan="3" class="header-cell">FECHA DE CALIBRACIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'fecha_calibracion')['value'] ?? '' }}</td>
            </tr>


            <!-- Séptima fila: Equipo y medio utilizado -->
            <tr>
                <td colspan="2" class="header-cell">EQUIPO Y MEDIO UTILIZADO: {{ collect($report->fieldReports)->firstWhere('field', 'equipo_medio_utilizado')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">EQUIPO / PIEZA A INSPECCIONAR: {{ collect($report->fieldReports)->firstWhere('field', 'equipo_pieza_inspeccionar')['value'] ?? '' }}</td>
            </tr>


            <!-- Octava fila: Zona a inspeccionar y Material -->
            <tr>
                <td colspan="2" class="header-cell">ZONA A INSPECCIONAR: {{ collect($report->fieldReports)->firstWhere('field', 'zona_inspeccionar')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">MATERIAL: {{ collect($report->fieldReports)->firstWhere('field', 'material')['value'] ?? '' }}</td>
            </tr>


            <!-- Novena fila: Presión de diseño y presión de prueba -->
            <tr>
                <td colspan="2" class="header-cell">PRESIÓN DE DISEÑO: {{ collect($report->fieldReports)->firstWhere('field', 'presion_diseno')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">PRESIÓN DE PRUEBA: {{ collect($report->fieldReports)->firstWhere('field', 'presion_prueba')['value'] ?? '' }}</td>
            </tr>
            <!-- Décima fila: Tiempo y factor -->
            <tr>
                <td colspan="2" class="header-cell">TIEMPO DE PERMANENCIA: {{ collect($report->fieldReports)->firstWhere('field', 'tiempo_permanencia')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">FACTOR DE RELACIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'factor_relacion')['value'] ?? '' }}</td>
            </tr>
            <!-- Undécima fila: Temperaturas -->
            <tr>
                <td colspan="2" class="header-cell">TEMPERATURA DE PRUEBA: {{ collect($report->fieldReports)->firstWhere('field', 'temperatura_prueba')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">TEMPERATURA RECOMENDADA: {{ collect($report->fieldReports)->firstWhere('field', 'temperatura_recomendada')['value'] ?? '' }}</td>
            </tr>


            <!-- Duodécima fila: Instrumento de medición y fecha de calibración -->
            <tr>
                <td class="header-cell">INSTRUMENTO DE<br>MEDICIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'instrumento_medicion_temp')['value'] ?? '' }}</td>
                <td class="header-cell">CÓDIGO METROLÓGICO: {{ collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico_temp')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">FECHA DE CALIBRACIÓN : {{ collect($report->fieldReports)->firstWhere('field', 'fecha_calibracion_temp')['value'] ?? '' }}</td>
            </tr>


            <!-- Decimotercera fila: Regulación aplicada -->
            <tr>
                <td colspan="4" class="header-cell">REGULACIÓN APLICADA:</td>
            </tr>
            <tr>
                <td colspan="4" style="font-size: 8px;">
                    {{ collect($report->fieldReports)->firstWhere('field', 'regulacion_aplicada')['value'] ?? 'Rules and Regulations for the classification of ships Part II Hull Structures of Bureau Veritas. Section 3-04 Structural and Tightness Testing' }}
                </td>
            </tr>

            <!-- Decimocuarta fila: Resultado de la prueba -->
            @php
            $resultadoPrueba = collect($report->fieldReports)->firstWhere('field', 'resultado_prueba')['value'] ?? '';
            @endphp
            <tr>
                <td colspan="4" class="header-cell">RESULTADO DE LA PRUEBA: {{ $resultadoPrueba }}</td>
            </tr>
            <tr>
                <td colspan="4" style="text-align: center;">
                    <span class="checkbox-group">
                        <span class="checkbox {{ $resultadoPrueba == 'satisfactorio' ? 'checked' : '' }}"></span> SATISFACTORIO
                    </span>
                    <span class="checkbox-group">
                        <span class="checkbox {{ $resultadoPrueba == 'no_satisfactorio' ? 'checked' : '' }}"></span> NO SATISFACTORIO
                    </span>
                </td>
            </tr>

            <!-- Decimoquinta fila: Observaciones -->
            <tr>
                <td colspan="4" class="header-cell">OBSERVACIONES:</td>
            </tr>
            <tr class="observations-row">
                <td colspan="4" style="height: 50px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'observaciones')['value'] ?? '' !!}
                    
                </td>
            </tr>

            <!-- Última fila: Firmas -->
            @php
                $elaborado_por_firma = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_firma')['value'] ?? null;
                $elaborado_por_nombre = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_nombre')['value'] ?? '';
                $elaborado_por_cargo = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_cargo')['value'] ?? '';
                $revisado_por_firma = collect($report->fieldReports)->firstWhere('field', 'revisado_por_firma')['value'] ?? null;
                $revisado_por_nombre = collect($report->fieldReports)->firstWhere('field', 'revisado_por_nombre')['value'] ?? '';
                $revisado_por_cargo = collect($report->fieldReports)->firstWhere('field', 'revisado_por_cargo')['value'] ?? '';
            @endphp
            <tr>
                <td colspan="4">
                    @include('pdf.partials.firmas-section')
                </td>
            </tr>
        </table>
    </main>

</body>

</html>