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
            border: 1px solid black;
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
            content: "✓";
            display: block;
            text-align: center;
            font-weight: bold;
            line-height: 12px;
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
            border-top: 1px solid black;
            margin-top: 50px;
            padding-top: 5px;
            text-align: center;
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
                $tipoPrueba = collect($report->fieldReports)->firstWhere('field', 'tipo_prueba')['value'] ?? '';
                $montajeDispositivo = collect($report->fieldReports)->firstWhere('field', 'montaje_dispositivo')['value'] ?? '';
            @endphp
            <tr>
                <td rowspan="2" class="header-cell" style="width: 25%;">TIPO DE PRUEBA: {{ $tipoPrueba }}</td>
                <td>
                    <span class="checkbox-group">
                        <span class="checkbox {{ $tipoPrueba == 'hidrostatica' ? 'checked' : '' }}"></span> HIDROSTÁTICA
                    </span>
                    <span class="checkbox-group">
                        <span class="checkbox {{ $tipoPrueba == 'neumatica' ? 'checked' : '' }}"></span> NEUMÁTICA
                    </span>
                    <span class="checkbox-group">
                        <span class="checkbox {{ $tipoPrueba == 'vacio' ? 'checked' : '' }}"></span> VACÍO
                    </span>
                </td>
                <td colspan="2" rowspan="2">
                    <table style="border: none; width: 100%;">
                        <tr>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ $montajeDispositivo == 'division_soldadura' ? 'checked' : '' }}"></span> 
                                <strong>División de Soldadura</strong>
                            </td>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ $montajeDispositivo == 'division_motores' ? 'checked' : '' }}"></span> 
                                <strong>División de Motores</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ $montajeDispositivo == 'division_mecanica' ? 'checked' : '' }}"></span> 
                                <strong>División de Mecánica</strong>
                            </td>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ $montajeDispositivo == 'casco_estructura' ? 'checked' : '' }}"></span> 
                                <strong>Casco y Estructura - Maquinaria</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ $montajeDispositivo == 'contratista' ? 'checked' : '' }}"></span> 
                                <strong>Contratista</strong>
                            </td>
                            <td style="border: none; padding: 2px;" colspan="2">
                                <span class="checkbox {{ $montajeDispositivo == 'propulsion_electricidad' ? 'checked' : '' }}"></span> 
                                <strong>Propulsión y Electricidad.</strong>
                            </td>
                        </tr>
                        <tr>
                            <td style="border: none; padding: 2px;" colspan="4">
                                <span class="checkbox {{ $montajeDispositivo == 'otro' ? 'checked' : '' }}"></span> 
                                <strong>Otro:</strong> {{ $montajeDispositivo == 'otro' ? collect($report->fieldReports)->firstWhere('field', 'montaje_otro')['value'] ?? '' : '' }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td class="header-cell">
                    <strong>MONTAJE DEL<br>DISPOSITIVO DE LA<br>PRUEBA.</strong>
                </td>
            </tr>

            <!-- Cuarta fila: INSPECCIÓN REALIZADA POR -->
            <tr>
                <td colspan="4" class="header-cell">INSPECCIÓN REALIZADA POR:</td>
            </tr>
            <tr>
                <td colspan="4">{{ $report->user->name ?? '' }}</td>
            </tr>

            <!-- Quinta fila: Instrumento, Rango, Unidad -->
            <tr>
                <td class="header-cell">INSTRUMENTO DE MEDICIÓN:</td>
                <td class="header-cell">RANGO:</td>
                <td colspan="2" class="header-cell">UNIDAD DE MEDIDA:</td>
            </tr>
            <tr>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'instrumento_medicion')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'rango')['value'] ?? '' }}</td>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'unidad_medida')['value'] ?? '' }}</td>
            </tr>

            <!-- Sexta fila: Código metrológico y fecha de calibración -->
            <tr>
                <td colspan="2" class="header-cell">CÓDIGO METROLÓGICO:</td>
                <td colspan="2" class="header-cell">FECHA DE CALIBRACIÓN:</td>
            </tr>
            <tr>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico')['value'] ?? '' }}</td>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'fecha_calibracion')['value'] ?? '' }}</td>
            </tr>

            <!-- Séptima fila: Equipo y medio utilizado -->
            <tr>
                <td colspan="2" class="header-cell">EQUIPO Y MEDIO UTILIZADO:</td>
                <td colspan="2" class="header-cell">EQUIPO / PIEZA A INSPECCIONAR:</td>
            </tr>
            <tr>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'equipo_medio_utilizado')['value'] ?? '' }}</td>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'equipo_pieza_inspeccionar')['value'] ?? '' }}</td>
            </tr>

            <!-- Octava fila: Zona a inspeccionar y Material -->
            <tr>
                <td colspan="2" class="header-cell">ZONA A INSPECCIONAR:</td>
                <td colspan="2" class="header-cell">MATERIAL:</td>
            </tr>
            <tr>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'zona_inspeccionar')['value'] ?? '' }}</td>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'material')['value'] ?? '' }}</td>
            </tr>

            <!-- Novena fila: Presión de diseño y presión de prueba -->
            <tr>
                <td colspan="2" class="header-cell">PRESIÓN DE DISEÑO:</td>
                <td colspan="2" class="header-cell">PRESIÓN DE PRUEBA:</td>
            </tr>
            <tr>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'presion_diseno')['value'] ?? '' }}</td>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'presion_prueba')['value'] ?? '' }}</td>
            </tr>

            <!-- Décima fila: Tiempo y factor -->
            <tr>
                <td colspan="2" class="header-cell">TIEMPO DE PERMANENCIA:</td>
                <td colspan="2" class="header-cell">FACTOR DE RELACIÓN:</td>
            </tr>
            <tr>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'tiempo_permanencia')['value'] ?? '' }}</td>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'factor_relacion')['value'] ?? '' }}</td>
            </tr>

            <!-- Undécima fila: Temperaturas -->
            <tr>
                <td colspan="2" class="header-cell">TEMPERATURA DE PRUEBA:</td>
                <td colspan="2" class="header-cell">TEMPERATURA RECOMENDADA:</td>
            </tr>
            <tr>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'temperatura_prueba')['value'] ?? '' }}</td>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'temperatura_recomendada')['value'] ?? '' }}</td>
            </tr>

            <!-- Duodécima fila: Instrumento de medición y fecha de calibración -->
            <tr>
                <td class="header-cell">INSTRUMENTO DE<br>MEDICIÓN:</td>
                <td class="header-cell">CÓDIGO METROLÓGICO:</td>
                <td colspan="2" class="header-cell">FECHA DE CALIBRACIÓN:</td>
            </tr>
            <tr>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'instrumento_medicion_temp')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico_temp')['value'] ?? '' }}</td>
                <td colspan="2">{{ collect($report->fieldReports)->firstWhere('field', 'fecha_calibracion_temp')['value'] ?? '' }}</td>
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
                <td colspan="4" class="header-cell">RESULTADO DE LA PRUEBA:</td>
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
            <tr>
                <td colspan="4" style="height: 100px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'observaciones')['value'] ?? '' !!}
                </td>
            </tr>

            <!-- Última fila: Firmas -->
            <tr>
                <td colspan="2">
                    <div style="padding: 10px;">
                        <strong>ELABORADO POR (Done by):</strong>
                        <div class="signature-box">
                            @if($report->user->signature)
                                <img src="{{ public_path('storage/' . $report->user->signature) }}" 
                                     alt="Firma" 
                                     style="width: 100%; max-height: 50px; object-fit: contain;">
                            @endif
                            <div style="margin-top: 5px;">(FIRMA)</div>
                        </div>
                        <div style="margin-top: 10px;"><strong>NOMBRE:</strong> {{ $report->user->name ?? '' }}</div>
                        <div><strong>CARGO:</strong> {{ $report->user->cargo ?? 'Auxiliar de investigación y desarrollo' }}</div>
                    </div>
                </td>
                <td colspan="2">
                    <div style="padding: 10px;">
                        <strong>REVISADO Y AUTORIZADO POR (Authorized by):</strong>
                        <div class="signature-box">
                            @if($report->user->signature)
                                <img src="{{ public_path('storage/' . $report->user->signature) }}" 
                                     alt="Firma" 
                                     style="width: 100%; max-height: 50px; object-fit: contain;">
                            @endif
                            <div style="margin-top: 5px;">(FIRMA)</div>
                        </div>
                        <div style="margin-top: 10px;"><strong>NOMBRE:</strong> {{ $report->user->name ?? '' }}</div>
                        <div><strong>CARGO:</strong> {{ $report->user->cargo ?? 'Auxiliar de investigación y desarrollo' }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </main>

</body>

</html>
