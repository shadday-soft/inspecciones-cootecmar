<!doctype html>
<html lang='es'>

<head>
    <title>Ensayos No Destructivos - Líquidos Penetrantes</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

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

        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>
    <header>
        <x-pdf.liquidos-penetrantes-detallado-header></x-pdf.liquidos-penetrantes-detallado-header>
    </header>

    <main>
        <!-- Primera tabla: Información general -->
        <table class="form-table">
            <tr>
                <td class="header-cell" style="width: 25%;">INFORME No.: {{ collect($report->fieldReports)->firstWhere('field', 'informe_no')['value'] ?? '' }}</td>
                <td class="header-cell" style="width: 25%;">FECHA: {{ collect($report->fieldReports)->firstWhere('field', 'fecha')['value'] ?? '' }}</td>
                <td class="header-cell" style="width: 25%;">G.O No.: {{ collect($report->fieldReports)->firstWhere('field', 'go_no')['value'] ?? '' }}</td>
                <td class="header-cell" style="width: 25%;">PÁG. No. Página 1 de 2</td>
            </tr>
            <tr>
                <td class="header-cell">CLIENTE: {{ collect($report->fieldReports)->firstWhere('field', 'cliente')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">PROYECTO: {{ collect($report->fieldReports)->firstWhere('field', 'proyecto')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">SITIO DE INSPECCIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'sitio_inspeccion')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">CIUDAD: {{ collect($report->fieldReports)->firstWhere('field', 'ciudad')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">ESPECIFICACIÓN (NORMA): {{ collect($report->fieldReports)->firstWhere('field', 'especificacion')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">GERENCIA: {{ collect($report->fieldReports)->firstWhere('field', 'gerencia')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="4" class="header-cell">PIEZA A INSPECCIONAR: {{ collect($report->fieldReports)->firstWhere('field', 'pieza_inspeccionar')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">MATERIAL: {{ collect($report->fieldReports)->firstWhere('field', 'material')['value'] ?? '' }}</td>
                <td colspan="3" class="header-cell">DIMENSIONES: {{ collect($report->fieldReports)->firstWhere('field', 'dimensiones')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">ÁREA INSPECCIONADA: {{ collect($report->fieldReports)->firstWhere('field', 'area_inspeccionada')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">ACABADO SUPERFICIAL: {{ collect($report->fieldReports)->firstWhere('field', 'acabado_superficial')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">TEMPERATURA DE LA PIEZA: {{ collect($report->fieldReports)->firstWhere('field', 'temperatura_pieza')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">HUMEDAD RELATIVA: {{ collect($report->fieldReports)->firstWhere('field', 'humedad_relativa')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">INSTRUMENTO DE MEDICIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'instrumento_medicion')['value'] ?? '' }}</td>
                <td class="header-cell">CÓDIGO METROLÓGICO: {{ collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico')['value'] ?? '' }}</td>
                <td colspan="2" class="header-cell">FECHA DE CALIBRACIÓN: {{ collect($report->fieldReports)->firstWhere('field', 'fecha_calibracion')['value'] ?? '' }}</td>
            </tr>
        </table>

        <!-- Tabla de Tipo de Materiales -->
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <td class="header-cell" style="text-align: center; width: 25%;">TIPO DE MATERIALES.</td>
                <td class="header-cell" style="text-align: center; width: 25%;">FABRICANTE</td>
                <td class="header-cell" style="text-align: center; width: 25%;">REF. COMERCIAL</td>
                <td class="header-cell" style="text-align: center; width: 25%;">LOTE No</td>
            </tr>
            <tr>
                <td class="header-cell">PENETRANTE:</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'fabricante_penetrante')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'ref_comercial_penetrante')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'lote_penetrante')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">EMULSIFICANTE:</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'fabricante_emulsificante')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'ref_comercial_emulsificante')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'lote_emulsificante')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">LIMPIADOR/REMOVEDOR:</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'fabricante_limpiador')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'ref_comercial_limpiador')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'lote_limpiador')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">REVELADOR:</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'fabricante_revelador')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'ref_comercial_revelador')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', 'lote_revelador')['value'] ?? '' }}</td>
            </tr>
        </table>

        <!-- Condiciones de Inspección -->
        @php
        $prelimpieza = collect($report->fieldReports)->firstWhere('field', 'prelimpieza')['value'] ?? '';
        $penetranteTipo = collect($report->fieldReports)->firstWhere('field', 'penetrante_tipo')['value'] ?? '';
        $metodoRemocion = collect($report->fieldReports)->firstWhere('field', 'metodo_remocion')['value'] ?? '';
        $reveladorTipo = collect($report->fieldReports)->firstWhere('field', 'revelador_tipo')['value'] ?? '';
        $iluminacion = collect($report->fieldReports)->firstWhere('field', 'iluminacion')['value'] ?? '';
        @endphp
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <td colspan="4" class="header-cell" style="background-color: #d0d0d0;">CONDICIONES DE INSPECCIÓN:</td>
            </tr>
            <tr>
                <td class="header-cell" style="width: 25%;">PRELIMPIEZA:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($prelimpieza, 'QUÍMICA') ? 'checked' : '' }}"></span> QUÍMICA
                    <span class="checkbox {{ str_contains($prelimpieza, 'MECÁNICA') ? 'checked' : '' }}"></span> MECÁNICA
                    <span class="checkbox {{ str_contains($prelimpieza, 'POR SOLVENTES') ? 'checked' : '' }}"></span> POR SOLVENTES
                </td>
            </tr>
            <tr>
                <td class="header-cell">PENETRANTE:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($penetranteTipo, 'VISIBLE O COLOREADO') ? 'checked' : '' }}"></span> VISIBLE O COLOREADO
                    <span class="checkbox {{ str_contains($penetranteTipo, 'FLUORESCENTE') ? 'checked' : '' }}"></span> FLUORESCENTE
                    <span class="checkbox {{ str_contains($penetranteTipo, 'DUALES') ? 'checked' : '' }}"></span> DUALES
                </td>
            </tr>
            <tr>
                <td class="header-cell">MÉTODO REMOCIÓN DEL PENETRANTE:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($metodoRemocion, 'LAVABLE-AGUA') ? 'checked' : '' }}"></span> LAVABLE-AGUA
                    <span class="checkbox {{ str_contains($metodoRemocion, 'POST-EMULSIFICABLE') ? 'checked' : '' }}"></span> POST-EMULSIFICABLE
                    <span class="checkbox {{ str_contains($metodoRemocion, 'SOLVENTE') ? 'checked' : '' }}"></span> SOLVENTE
                </td>
            </tr>
            <tr>
                <td class="header-cell">REVELADOR:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($reveladorTipo, 'POLVO SECO') ? 'checked' : '' }}"></span> POLVO SECO
                    <span class="checkbox {{ str_contains($reveladorTipo, 'SUSPENSIÓN NO ACUOSO') ? 'checked' : '' }}"></span> SUSPENSIÓN NO ACUOSO
                    <span class="checkbox {{ str_contains($reveladorTipo, 'EN SOLUCIÓN ACUOSA') ? 'checked' : '' }}"></span> EN SOLUCIÓN ACUOSA
                    <span class="checkbox {{ str_contains($reveladorTipo, 'SUSPENSIÓN ACUOSA') ? 'checked' : '' }}"></span> SUSPENSIÓN ACUOSA
                </td>
            </tr>
            <tr>
                <td class="header-cell">ILUMINACIÓN:</td>
                <td colspan="3">
                    <span class="checkbox {{ str_contains($iluminacion, 'VISIBLE') ? 'checked' : '' }}"></span> VISIBLE
                    <span class="checkbox {{ str_contains($iluminacion, 'UV') ? 'checked' : '' }}"></span> UV
                </td>
            </tr>
        </table>

        <!-- Parámetros de Operación -->
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <td class="header-cell" style="text-align: center; width: 20%;">PARÁMETROS DE OPERACIÓN</td>
                <td class="header-cell" style="text-align: center; width: 20%;">TIEMPO DE PERMANENCIA</td>
                <td class="header-cell" style="text-align: center; width: 20%;">TEMP. °C DE INSP.</td>
                <td class="header-cell" style="text-align: center; width: 20%;">MÉTODO APLICACIÓN</td>
                <td class="header-cell" style="text-align: center; width: 20%;">ILUMINACIÓN</td>
            </tr>
            @foreach(['param_secado1' => 'SECADO', 'param_penetrante' => 'PENETRANTE', 'param_emulsificador' => 'EMULSIFICADOR', 'param_enjuague' => 'ENJUAGUE', 'param_secado2' => 'SECADO', 'param_revelado' => 'REVELADO'] as $key => $label)
            <tr>
                <td class="header-cell">{{ $label }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', $key.'_tiempo')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', $key.'_temperatura')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', $key.'_metodo')['value'] ?? '' }}</td>
                <td>{{ collect($report->fieldReports)->firstWhere('field', $key.'_iluminacion')['value'] ?? '' }}</td>
            </tr>
            @endforeach
        </table>

        <div class="page-break"></div>

        <!-- Página 2: Tabla de Discontinuidades -->
        <header>
            <x-pdf.liquidos-penetrantes-detallado-header></x-pdf.liquidos-penetrantes-detallado-header>
        </header>

        <table class="form-table">
            <tr>
                <td colspan="6" class="header-cell" style="background-color: #d0d0d0;">4. CROQUIS (Detalle ver Pág. 2)</td>
            </tr>
            <tr>
                <td class="header-cell" style="text-align: center; width: 5%;">ITEM</td>
                <td class="header-cell" style="text-align: center; width: 20%;">UBICACIÓN</td>
                <td class="header-cell" style="text-align: center; width: 25%;">DESCRIPCIÓN DE LA DISCONTINUIDAD</td>
                <td class="header-cell" style="text-align: center; width: 15%;">FORMA<br><small>(LINEAL/REDONDA)</small></td>
                <td class="header-cell" style="text-align: center; width: 15%;">DIMENSIÓN</td>
                <td class="header-cell" style="text-align: center; width: 20%;">EVALUACIÓN<br><small>(ACEPTADA/RECHAZADA)</small></td>
            </tr>
            @php
            $discontinuidades = json_decode(collect($report->fieldReports)->firstWhere('field', 'discontinuidades')['value'] ?? '[]', true);
            @endphp
            @foreach(range(1, 13) as $i)
            @php
            $disc = $discontinuidades[$i-1] ?? ['ubicacion' => '', 'descripcion' => '', 'forma' => '', 'dimension' => '', 'evaluacion' => ''];
            @endphp
            <tr>
                <td style="text-align: center;">{{ $i }}</td>
                <td>{{ $disc['ubicacion'] ?? '' }}</td>
                <td>{{ $disc['descripcion'] ?? '' }}</td>
                <td style="text-align: center;">{{ $disc['forma'] ?? '' }}</td>
                <td>{{ $disc['dimension'] ?? '' }}</td>
                <td style="text-align: center;">{{ $disc['evaluacion'] ?? '' }}</td>
            </tr>
            @endforeach
        </table>

        <!-- Detalle de la Pieza -->
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <td class="header-cell">DETALLE DE LA PIEZA:</td>
            </tr>
            <tr>
                <td style="min-height: 200px; text-align: center; padding: 10px;">
                    @php
                    $detallePiezaImagen = collect($report->fieldReports)->firstWhere('field', 'detalle_pieza')['value'] ?? '';
                    @endphp
                    @if($detallePiezaImagen && str_starts_with($detallePiezaImagen, 'data:image'))
                        <img src="{{ $detallePiezaImagen }}" 
                             alt="Detalle de la pieza" 
                             style="max-width: 100%; max-height: 250px; object-fit: contain; display: block; margin: 0 auto;">
                    @else
                        <div style="color: #999; font-style: italic; padding: 80px 0;">(INSERTAR IMAGEN)</div>
                    @endif
                </td>
            </tr>
        </table>

        <!-- Observaciones -->
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <td class="header-cell">OBSERVACIONES:</td>
            </tr>
            <tr>
                <td style="min-height: 60px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'observaciones')['value'] ?? '' !!}
                </td>
            </tr>
        </table>

        <!-- Resultado Final -->
        @php
        $resultadoFinal = collect($report->fieldReports)->firstWhere('field', 'resultado_final')['value'] ?? '';
        @endphp
        <table class="form-table" style="margin-top: 0;">
            <tr>
                <td colspan="2" class="header-cell">RESULTADO FINAL DE LA PRUEBA:</td>
                <td colspan="2">
                    <span class="checkbox {{ $resultadoFinal == 'SATISFACTORIA' ? 'checked' : '' }}"></span> SATISFACTORIA
                    <span class="checkbox {{ $resultadoFinal == 'NO SATISFACTORIA' ? 'checked' : '' }}"></span> NO SATISFACTORIA
                </td>
            </tr>

        </table>
    </main>

    @php
        $elaborado_por_firma = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_firma')['value'] ?? null;
        $elaborado_por_nombre = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_nombre')['value'] ?? '';
        $elaborado_por_cargo = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_cargo')['value'] ?? '';
        $revisado_por_firma = collect($report->fieldReports)->firstWhere('field', 'revisado_por_firma')['value'] ?? null;
        $revisado_por_nombre = collect($report->fieldReports)->firstWhere('field', 'revisado_por_nombre')['value'] ?? '';
        $revisado_por_cargo = collect($report->fieldReports)->firstWhere('field', 'revisado_por_cargo')['value'] ?? '';
    @endphp

    @include('pdf.partials.firmas-section')

</body>

</html>
