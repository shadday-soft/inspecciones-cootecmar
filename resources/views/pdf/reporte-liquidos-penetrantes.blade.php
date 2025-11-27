<!doctype html>
<html lang='es'>

<head>
    <title>Prueba de Fugas Mediante Líquidos Penetrantes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Use an absolute path when specifying the CSS so it works in the PDF --}}
    <link href='{{ public_path('css/reports/general.css') }}' rel='stylesheet'>
    <link href='{{ public_path('css/components/header.css') }}' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            margin: 0;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        table td,
        table th {
            border: 1px solid black;
            padding: 3px;
            text-align: left;
            vertical-align: top;
        }

        .form-table td {
            font-size: 8px;
        }

        .header-cell {
            background-color: #f0f0f0;
            font-weight: bold;
            font-size: 8px;
        }

        .checkbox-group {
            display: inline-block;
            margin-right: 10px;
        }

        .checkbox {
            display: inline-block;
            width: 10px;
            height: 10px;
            border: 1px solid black;
            margin-right: 3px;
            vertical-align: middle;
        }

        .checkbox.checked::before {
            content: "X";
            display: block;
            text-align: center;
            font-weight: bold;
            line-height: 10px;
            font-size: 10px;
        }

        .signature-section {
            margin-top: 15px;
        }

        .signature-box {
            border-bottom: 1px solid black;
            margin-top: 40px;
            padding-top: 5px;
            text-align: center;
            min-height: 50px;
        }

        .signature-row {
            page-break-inside: avoid;
            break-inside: avoid;
        }

        .no-border {
            border: none;
        }

        .thick-border {
            border: 2px solid black;
        }
    </style>
</head>

<body>
    <header>
        <x-pdf.liquidos-penetrantes-header></x-pdf.liquidos-penetrantes-header>
    </header>

    <main>
        <table class="form-table">
            <!-- Primera fila: Informe No. y Fecha -->
            <tr>
                <td class="header-cell" style="width: 20%;">INFORME No.: {{ collect($report->fieldReports)->firstWhere('field', 'informe_no')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">FECHA: {{ collect($report->fieldReports)->firstWhere('field', 'fecha')['value'] ?? $report->inspection->fecha ?? '' }}</td>
            </tr>

            <!-- Segunda fila: Cliente y Proyecto -->
            <tr>
                <td class="header-cell" style="width: 20%;">CLIENTE: {{ collect($report->fieldReports)->firstWhere('field', 'cliente')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">PROYECTO: {{ collect($report->fieldReports)->firstWhere('field', 'proyecto')['value'] ?? $report->inspection->project->name ?? '' }}</td>
            </tr>

            <!-- Tercera fila: Sitio y Ciudad -->
            <tr>
                <td class="header-cell" style="width: 20%;">SITIO DE INSPECCIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'sitio_inspeccion')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">CIUDAD: {{ collect($report->fieldReports)->firstWhere('field', 'ciudad')['value'] ?? '' }}</td>
            </tr>

            <!-- Cuarta fila: Especificación y Gerencia -->
            <tr>
                <td class="header-cell">ESPECIFICACIÓN<br>(NORMA): {{ collect($report->fieldReports)->firstWhere('field', 'especificacion')['value'] ?? '' }}<br>{{ collect($report->fieldReports)->firstWhere('field', 'norma')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">GERENCIA: {{ collect($report->fieldReports)->firstWhere('field', 'gerencia')['value'] ?? $report->inspection['gerencia'] ?? '' }}</td>
            </tr>

            <!-- Quinta fila: Pieza y Material/Dimensiones -->
            <tr>
                <td class="header-cell">PIEZA INSPECCIONADA: {{ collect($report->fieldReports)->firstWhere('field', 'pieza_inspeccionada')['value'] ?? '' }}</td>
                <td colspan="3"></td>
            </tr>

            <tr>
                <td class="header-cell">MATERIAL: {{ collect($report->fieldReports)->firstWhere('field', 'material')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">DIMENSIONES: {{ collect($report->fieldReports)->firstWhere('field', 'dimensiones')['value'] ?? '' }}</td>
            </tr>

            <!-- Sexta fila: Acabado Superficial -->
            <tr>
                <td class="header-cell">ACABADO SUPERFICIAL: {{ collect($report->fieldReports)->firstWhere('field', 'acabado_superficial')['value'] ?? '' }}</td>
                
                <td colspan="3"  class="header-cell">FECHA DE CALIBRACIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'fecha_calibracion')['value'] ?? '' }}</td>
            </tr>

            <!-- Séptima fila: Instrumento de Medición -->
            <tr>
                <td class="header-cell">INSTRUMENTO DE MEDICIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'instrumento_medicion')['value'] ?? '' }}</td>
                <td class="header-cell">CÓDIGO METROLÓGICO: {{ collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico')['value'] ?? '' }}</td>
            </tr>

            <!-- CONDICIONES DE INSPECCIÓN -->
            @php
            $prelimpieza = collect($report->fieldReports)->firstWhere('field', 'prelimpieza')['value'] ?? '';
            $penetrante = collect($report->fieldReports)->firstWhere('field', 'penetrante')['value'] ?? '';
            $revelador = collect($report->fieldReports)->firstWhere('field', 'revelador')['value'] ?? '';
            $iluminacion = collect($report->fieldReports)->firstWhere('field', 'iluminacion')['value'] ?? '';
            @endphp
            <tr>
                <td colspan="4" class="header-cell" style="background-color: #d0d0d0;">CONDICIONES DE INSPECCIÓN:</td>
            </tr>
            <tr>
                <td class="header-cell">PRELIMPIEZA:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($prelimpieza, 'QUIMICA') ? 'checked' : '' }}"></span> QUÍMICA
                    <span class="checkbox {{ str_contains($prelimpieza, 'MECANICA') ? 'checked' : '' }}"></span> MECÁNICA
                    <span class="checkbox {{ str_contains($prelimpieza, 'POR SOLVENTES') ? 'checked' : '' }}"></span> POR SOLVENTES
                </td>
            </tr>
            <tr>
                <td class="header-cell">PENETRANTE:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($penetrante, 'ACPM') ? 'checked' : '' }}"></span> ACPM
                    <span class="checkbox {{ str_contains($penetrante, 'LÍQUIDO PENETRANTE') ? 'checked' : '' }}"></span> LÍQUIDO PENETRANTE (COLOREADO)
                    <span class="checkbox {{ str_contains($penetrante, 'OTRO') ? 'checked' : '' }}"></span> OTRO: {{ collect($report->fieldReports)->firstWhere('field', 'penetrante_otro')['value'] ?? '' }}
                </td>
            </tr>
            <tr>
                <td class="header-cell">REVELADOR:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($revelador, 'CAL') ? 'checked' : '' }}"></span> CAL
                    <span class="checkbox {{ str_contains($revelador, 'EN SOLUCION NO ACUOSA') ? 'checked' : '' }}"></span> EN SOLUCIÓN NO ACUOSA
                    <span class="checkbox {{ str_contains($revelador, 'OTRO') ? 'checked' : '' }}"></span> OTRO: {{ collect($report->fieldReports)->firstWhere('field', 'revelador_otro')['value'] ?? '' }}
                </td>
            </tr>
            <tr>
                <td class="header-cell">ILUMINACIÓN:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($iluminacion, 'VISIBLE') ? 'checked' : '' }}"></span> VISIBLE
                    <span class="checkbox {{ str_contains($iluminacion, 'LIMITADA') ? 'checked' : '' }}"></span> LIMITADA
                </td>
            </tr>
        </table>

        <!-- PARÁMETROS DE OPERACIÓN - Tabla separada con 5 columnas -->
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <td class="header-cell" style="text-align: center; width: 20%;">PARÁMETROS DE OPERACIÓN:</td>
                <td class="header-cell" style="text-align: center; width: 20%;">TIEMPO DE PERMANENCIA</td>
                <td class="header-cell" style="text-align: center; width: 20%;">TEMP. °C (PIEZA)</td>
                <td class="header-cell" style="text-align: center; width: 20%;">MÉTODO APLICACIÓN</td>
                <td class="header-cell" style="text-align: center; width: 20%;">ILUMINACIÓN</td>
            </tr>
            <tr>
                <td class="header-cell">SECADO</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_secado_tiempo')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_secado_temperatura')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_secado_metodo_aplicacion')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_secado_iluminacion')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">PENETRACIÓN</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_penetracion_tiempo')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_penetracion_temperatura')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_penetracion_metodo_aplicacion')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_penetracion_iluminacion')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">REVELADO</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_revelado_tiempo')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_revelado_temperatura')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_revelado_metodo_aplicacion')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'parametros_revelado_iluminacion')['value'] ?? '' }}</td>
            </tr>
        </table>

        <!-- Fabricantes y Referencias - Volver a tabla de 4 columnas -->
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <td class="no-border"></td>
                <td class="header-cell" style="text-align: center;">FABRICANTE</td>
                <td class="header-cell" style="text-align: center;">REF. COMERCIAL</td>
                <td class="header-cell" style="text-align: center;">LOTE No.</td>
            </tr>
            <tr>
                <td class="header-cell">LIMPIADOR</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'fabricante_limpiador')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'ref_comercial_limpiador')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'lote_limpiador')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">PENETRACIÓN</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'fabricante_penetracion')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'ref_comercial_penetracion')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'lote_penetracion')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">REVELADO</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'fabricante_revelado')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'ref_comercial_revelado')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'lote_revelado')['value'] ?? '' }}</td>
            </tr>
        </table>

        <!-- Observaciones y resto del documento - Nueva tabla de 4 columnas -->
        <table class="form-table" style="margin-top: 0;">
            <!-- Observaciones -->
            <tr>
                <td colspan="4" class="header-cell">OBSERVACIONES:</td>
            </tr>
            <tr>
                <td colspan="4" style="min-height: 60px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'observaciones')['value'] ?? '' !!}
                </td>
            </tr>

            <!-- Detalle del Área Inspeccionada -->
            <tr>
                <td colspan="4" class="header-cell">DETALLE DEL ÁREA INSPECCIONADA:</td>
            </tr>
            <tr>
                <td colspan="4" style="min-height: 80px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'detalle_area_inspeccionada')['value'] ?? '' !!}
                </td>
            </tr>

            <!-- Concepto de Ensayo -->
            @php
            $conceptoEnsayo = collect($report->fieldReports)->firstWhere('field', 'concepto_ensayo')['value'] ?? '';
            @endphp
            <tr>
                <td colspan="2" class="header-cell">CONCEPTO DE ENSAYO:</td>
                <td colspan="2">
                    <span class="checkbox {{ $conceptoEnsayo == 'satisfactorio' ? 'checked' : '' }}"></span> SATISFACTORIO
                    <span class="checkbox {{ $conceptoEnsayo == 'no_satisfactorio' ? 'checked' : '' }}"></span> NO SATISFACTORIO
                </td>
            </tr>

            <!-- Firmas -->
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
