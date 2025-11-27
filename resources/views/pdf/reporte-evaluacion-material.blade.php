<!doctype html>
<html lang='es'>

<head>
    <title>Evaluación de Material Crítico (Homologación)</title>
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

        .section-title {
            background-color: #4a5568;
            color: white;
            padding: 8px;
            font-weight: bold;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <header>
        <x-pdf.hermeticidad-header></x-pdf.hermeticidad-header>
    </header>

    <main>
        <div class="section-title">EVALUACIÓN DE MATERIAL CRÍTICO (HOMOLOGACIÓN)</div>
        
        <table class="form-table">
            <!-- Encabezado del formulario -->
            <tr>
                <td class="header-cell" style="width: 40%;">Código: F-COPSER-017</td>
                <td class="header-cell" style="width: 30%;">Versión: 0.0.3</td>
                <td class="header-cell" style="width: 30%;">Fecha de Aprobación: 05-jul-2011</td>
            </tr>
        </table>

        <!-- SECCIÓN I: PARTE DILIGENCIAMIENTO POR PARTE DEL PROVEEDOR -->
        <div class="section-title">I. PARTE DILIGENCIAMIENTO POR PARTE DEL PROVEEDOR</div>
        <table class="form-table">
            <tr>
                <td class="header-cell" style="width: 50%;">EMPRESA: {{ collect($report->fieldReports)->firstWhere('field', 'empresa')['value'] ?? '' }}</td>
                <td class="header-cell" style="width: 50%;">PRODUCTO A HOMOLOGAR: {{ collect($report->fieldReports)->firstWhere('field', 'producto_homologar')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell" style="width: 50%;">
                    TIPO DE EMPRESA: 
                    @php
                        $tipoEmpresa = collect($report->fieldReports)->firstWhere('field', 'tipo_empresa')['value'] ?? '';
                        $tipoEmpresaLabel = $tipoEmpresa === 'fabricante' ? 'FABRICANTE DEL PRODUCTO' : ($tipoEmpresa === 'distribuidor' ? 'DISTRIBUIDOR DEL PRODUCTO' : '');
                    @endphp
                    {{ $tipoEmpresaLabel }}
                </td>
                <td class="header-cell" style="width: 50%;">MARCA DEL PRODUCTO: {{ collect($report->fieldReports)->firstWhere('field', 'marca_producto')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell" style="width: 50%;">NORMA: {{ collect($report->fieldReports)->firstWhere('field', 'norma')['value'] ?? '' }}</td>
                <td class="header-cell" style="width: 50%;"></td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">DESCRIPCIÓN GENERAL DEL PRODUCTO:</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 80px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'descripcion_general')['value'] ?? '' !!}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">PROPIEDADES:</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 80px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'propiedades')['value'] ?? '' !!}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">OBJETIVOS / FUNCIONES DEL PRODUCTO:</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 80px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'objetivos_funciones')['value'] ?? '' !!}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">PROCEDIMIENTO DE APLICACIÓN (Instrucción de Manejo del material):</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 80px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'procedimiento_aplicacion')['value'] ?? '' !!}
                </td>
            </tr>
            <tr>
                <td class="header-cell">DATOS DEL PRODUCTO: Unidad de venta: {{ collect($report->fieldReports)->firstWhere('field', 'unidad_venta')['value'] ?? '' }}</td>
                <td class="header-cell">Presentación del Producto: {{ collect($report->fieldReports)->firstWhere('field', 'presentacion_producto')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">DISPONIBILIDAD EN OTRAS PRESENTACIONES:</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 60px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'disponibilidad_presentaciones')['value'] ?? '' !!}
                </td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">DISPONIBILIDAD DEL MATERIAL: {{ collect($report->fieldReports)->firstWhere('field', 'disponibilidad_material')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell" style="background-color: #e0e0e0;">ENVIAR LA SIGUIENTE INFORMACIÓN DEL PRODUCTO:</td>
            </tr>
            @php
            $fichaTecnica = collect($report->fieldReports)->firstWhere('field', 'ficha_tecnica')['value'] ?? '';
            $certificaciones = collect($report->fieldReports)->firstWhere('field', 'certificaciones_calidad')['value'] ?? '';
            $instrucciones = collect($report->fieldReports)->firstWhere('field', 'instrucciones_seguridad')['value'] ?? '';
            $asesoria = collect($report->fieldReports)->firstWhere('field', 'asesoria_tecnica')['value'] ?? '';
            @endphp
            <tr>
                <td class="header-cell" style="width: 50%;">
                    <span class="checkbox {{ str_contains($fichaTecnica, 'Sí') ? 'checked' : '' }}"></span> Ficha Técnica del producto
                </td>
                <td class="header-cell" style="width: 50%;">
                    <span class="checkbox {{ str_contains($certificaciones, 'Sí') ? 'checked' : '' }}"></span> Certificaciones o sellos de calidad del producto (certificación de origen)
                </td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">Aplicaciones aprobadas en otras organizaciones:</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 40px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'aplicaciones_aprobadas')['value'] ?? '' !!}
                </td>
            </tr>
            <tr>
                <td class="header-cell" style="width: 50%;">
                    <span class="checkbox {{ str_contains($instrucciones, 'Sí') ? 'checked' : '' }}"></span> Instrucciones de Seguridad Industrial
                </td>
                <td class="header-cell" style="width: 50%;">Referencias de sustancias químicas (MSDS)</td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">Recomendaciones de Almacenamiento:</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 40px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'recomendaciones_almacenamiento')['value'] ?? '' !!}
                </td>
            </tr>
            <tr>
                <td class="header-cell">Vida útil del material: {{ collect($report->fieldReports)->firstWhere('field', 'vida_util')['value'] ?? '' }}</td>
                <td class="header-cell">Garantía: {{ collect($report->fieldReports)->firstWhere('field', 'garantia')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td class="header-cell">Precio por Unidad de Venta: {{ collect($report->fieldReports)->firstWhere('field', 'precio_unidad')['value'] ?? '' }}</td>
                <td class="header-cell">Tiempo de Entrega: {{ collect($report->fieldReports)->firstWhere('field', 'tiempo_entrega')['value'] ?? '' }}</td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">
                    <span class="checkbox {{ str_contains($asesoria, 'Sí') ? 'checked' : '' }}"></span> Asesoría Técnica
                </td>
            </tr>
            <tr>
                <td colspan="2" class="header-cell">OBSERVACIONES (Proveedor):</td>
            </tr>
            <tr>
                <td colspan="2" style="min-height: 60px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'observaciones_proveedor')['value'] ?? '' !!}
                </td>
            </tr>
        </table>

        <!-- SECCIÓN II: RESULTADO DE LA EVALUACIÓN - COOTECMAR -->
        <div class="section-title">II. RESULTADO DE LA EVALUACIÓN - COOTECMAR</div>
        <table class="form-table">
            @php
            $resultadoEvaluacion = collect($report->fieldReports)->firstWhere('field', 'resultado_evaluacion')['value'] ?? '';
            @endphp
            <tr>
                <td class="header-cell">RESULTADO DE LA EVALUACIÓN:</td>
            </tr>
            <tr>
                <td style="text-align: center; padding: 10px;">
                    <span class="checkbox-group">
                        <span class="checkbox {{ $resultadoEvaluacion == 'aprobado' ? 'checked' : '' }}"></span> APROBADO
                    </span>
                    <span class="checkbox-group">
                        <span class="checkbox {{ $resultadoEvaluacion == 'rechazado' ? 'checked' : '' }}"></span> RECHAZADO
                    </span>
                </td>
            </tr>
            <tr>
                <td class="header-cell">OBSERVACIONES (COOTECMAR):</td>
            </tr>
            <tr>
                <td style="min-height: 80px;">
                    {!! collect($report->fieldReports)->firstWhere('field', 'observaciones_cootecmar')['value'] ?? '' !!}
                </td>
            </tr>
        </table>

        <!-- FIRMAS -->
        <table class="form-table" style="margin-top: 30px;">
            <tr class="signature-row">
                <td colspan="2">
                    <div style="padding: 10px;">
                        <strong>EVALUADO POR (Evaluated by):</strong>
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
                    @php
                    $reviewedBySignature = collect($report->fieldReports)->firstWhere('field', 'reviewed_by_signature')['value'] ?? null;
                    $reviewedByName = collect($report->fieldReports)->firstWhere('field', 'reviewed_by_name')['value'] ?? '';
                    $reviewedByCargo = collect($report->fieldReports)->firstWhere('field', 'reviewed_by_cargo')['value'] ?? 'Auxiliar de investigación y desarrollo';
                    @endphp
                    <div style="padding: 10px;">
                        <strong>REVISADO Y AUTORIZADO POR (Authorized by):</strong>
                        <div class="signature-box">
                            @if($reviewedBySignature)
                            <img src="{{ $reviewedBySignature }}"
                                alt="Firma"
                                style="width: 100%; max-height: 50px; object-fit: contain;">
                            @endif
                            <div style="margin-top: 5px;">(FIRMA)</div>
                        </div>
                        <div style="margin-top: 10px;"><strong>NOMBRE:</strong> {{ $reviewedByName }}</div>
                        <div><strong>CARGO:</strong> {{ $reviewedByCargo }}</div>
                    </div>
                </td>
            </tr>
        </table>
    </main>

</body>

</html>
