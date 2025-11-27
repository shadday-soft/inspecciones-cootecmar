<!doctype html>
<html lang='es'>

<head>
    <title>Control Dimensional</title>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 100px 50px 80px 50px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            line-height: 1.3;
        }

        header {
            position: fixed;
            top: -80px;
            left: 0;
            right: 0;
            height: 70px;
        }

        footer {
            position: fixed;
            bottom: -60px;
            left: 0;
            right: 0;
            height: 50px;
            text-align: center;
            font-size: 8px;
        }

        main {
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 5px;
        }

        th,
        td {
            border: 2px solid #000;
            padding: 4px;
            vertical-align: middle;
        }

        th {
            background-color: #f0f0f0;
            font-weight: bold;
            text-align: center;
        }

        .no-border {
            border: none;
        }

        .text-center {
            text-align: center;
        }

        .text-bold {
            font-weight: bold;
        }

        .bg-gray {
            background-color: #e0e0e0;
        }

        .croquis-container {
            text-align: center;
            padding: 10px;
            min-height: 200px;
            background-color: #f9f9f9;
        }

        .croquis-container img {
            max-width: 100%;
            max-height: 300px;
            object-fit: contain;
        }

        .checkbox {
            display: inline-block;
            width: 12px;
            height: 12px;
            border: 2px solid #000;
            margin-right: 5px;
            vertical-align: middle;
        }

        .checkbox.checked::after {
            content: '✓';
            display: block;
            text-align: center;
            font-weight: bold;
            line-height: 12px;
            font-size: 12px;
        }
    </style>
</head>

<body>
    <header>
        @include('pdf.headers.control-dimensional-header')
    </header>

    <main>
        @php
            $gerencia = collect($report->fieldReports)->firstWhere('field', 'gerencia')['value'] ?? '';
            $proyecto = collect($report->fieldReports)->firstWhere('field', 'proyecto')['value'] ?? '';
            $descripcion = collect($report->fieldReports)->firstWhere('field', 'descripcion')['value'] ?? '';
            $plano = collect($report->fieldReports)->firstWhere('field', 'plano')['value'] ?? '';
            $subproceso = collect($report->fieldReports)->firstWhere('field', 'subproceso')['value'] ?? '';
            $fecha = collect($report->fieldReports)->firstWhere('field', 'fecha')['value'] ?? '';
            $hora = collect($report->fieldReports)->firstWhere('field', 'hora')['value'] ?? '';
            $registro_no = collect($report->fieldReports)->firstWhere('field', 'registro_no')['value'] ?? '';
            
            $parte = collect($report->fieldReports)->firstWhere('field', 'parte')['value'] ?? '';
            $posn = collect($report->fieldReports)->firstWhere('field', 'posn')['value'] ?? '';
            $temperatura_pieza = collect($report->fieldReports)->firstWhere('field', 'temperatura_pieza')['value'] ?? '';
            
            $equipo_medicion_1 = collect($report->fieldReports)->firstWhere('field', 'equipo_medicion_1')['value'] ?? '';
            $codigo_metrologico_1 = collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico_1')['value'] ?? '';
            $equipo_medicion_2 = collect($report->fieldReports)->firstWhere('field', 'equipo_medicion_2')['value'] ?? '';
            $codigo_metrologico_2 = collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico_2')['value'] ?? '';
            
            $croquis = collect($report->fieldReports)->firstWhere('field', 'croquis')['value'] ?? '';
            
            $accion_seguir = collect($report->fieldReports)->firstWhere('field', 'accion_seguir')['value'] ?? '';
            $responsable = collect($report->fieldReports)->firstWhere('field', 'responsable')['value'] ?? '';
            $plazo = collect($report->fieldReports)->firstWhere('field', 'plazo')['value'] ?? '';
            
            $aprobado_para = collect($report->fieldReports)->firstWhere('field', 'aprobado_para')['value'] ?? '';
            if (is_string($aprobado_para)) {
                $aprobado_para = json_decode($aprobado_para, true) ?? [];
            }
            
            // Extraer dimensiones
            $dimensiones = [];
            $cotas = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n'];
            foreach ($cotas as $cota) {
                $dimensiones[] = [
                    'cota' => strtoupper($cota),
                    'valor_teorico' => collect($report->fieldReports)->firstWhere('field', "dimension_{$cota}_valor_teorico")['value'] ?? '',
                    'tolerancia' => collect($report->fieldReports)->firstWhere('field', "dimension_{$cota}_tolerancia")['value'] ?? '',
                    'valor_real' => collect($report->fieldReports)->firstWhere('field', "dimension_{$cota}_valor_real")['value'] ?? '',
                    'desviacion' => collect($report->fieldReports)->firstWhere('field', "dimension_{$cota}_desviacion")['value'] ?? '',
                    'resultado' => collect($report->fieldReports)->firstWhere('field', "dimension_{$cota}_resultado")['value'] ?? '',
                ];
            }

            $elaborado_por_firma = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_firma')['value'] ?? null;
            $elaborado_por_nombre = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_nombre')['value'] ?? '';
            $elaborado_por_cargo = collect($report->fieldReports)->firstWhere('field', 'elaborado_por_cargo')['value'] ?? '';
            $revisado_por_firma = collect($report->fieldReports)->firstWhere('field', 'revisado_por_firma')['value'] ?? null;
            $revisado_por_nombre = collect($report->fieldReports)->firstWhere('field', 'revisado_por_nombre')['value'] ?? '';
            $revisado_por_cargo = collect($report->fieldReports)->firstWhere('field', 'revisado_por_cargo')['value'] ?? '';
        @endphp

        <!-- Tabla de información general -->
        <table style="margin-bottom: 5px;">
            <tr>
                <td style="width: 15%; background-color: #f0f0f0;"><strong>GERENCIA:</strong></td>
                <td style="width: 35%;">{{ $gerencia }}</td>
                <td style="width: 15%; background-color: #f0f0f0;"><strong>FECHA:</strong></td>
                <td style="width: 15%;">{{ $fecha }}</td>
                <td style="width: 10%; background-color: #f0f0f0;"><strong>HORA:</strong></td>
                <td style="width: 10%;">{{ $hora }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>PROYECTO:</strong></td>
                <td colspan="5">{{ $proyecto }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>DESCRIPCIÓN:</strong></td>
                <td colspan="3">{{ $descripcion }}</td>
                <td style="background-color: #f0f0f0;"><strong>REGISTRO No.:</strong></td>
                <td>{{ $registro_no }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>PLANO:</strong></td>
                <td colspan="2">{{ $plano }}</td>
                <td style="background-color: #f0f0f0;"><strong>PARTE:</strong></td>
                <td colspan="2">{{ $parte }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>SUBPROCESO:</strong></td>
                <td colspan="2">{{ $subproceso }}</td>
                <td style="background-color: #f0f0f0;"><strong>POSN:</strong></td>
                <td colspan="2">{{ $posn }}</td>
            </tr>
            <tr>
                <td colspan="3" style="background-color: #f0f0f0;"><strong>TEMPERATURA DE LA PIEZA:</strong></td>
                <td colspan="3">{{ $temperatura_pieza }}</td>
            </tr>
        </table>

        <!-- Tabla principal con croquis y dimensiones -->
        <table style="margin-bottom: 5px;">
            <tr>
                <!-- Columna izquierda: Equipos de medición y Croquis -->
                <td style="width: 40%; vertical-align: top;">
                    <!-- Equipos de medición -->
                    <table style="width: 100%; margin-bottom: 5px;">
                        <tr>
                            <th colspan="2" class="bg-gray">EQUIPO DE MEDICIÓN</th>
                            <th colspan="2" class="bg-gray">CÓDIGO METROLÓGICO</th>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $equipo_medicion_1 }}</td>
                            <td colspan="2">{{ $codigo_metrologico_1 }}</td>
                        </tr>
                        <tr>
                            <td colspan="2">{{ $equipo_medicion_2 }}</td>
                            <td colspan="2">{{ $codigo_metrologico_2 }}</td>
                        </tr>
                    </table>

                    <!-- Croquis -->
                    <div class="croquis-container">
                        @if(!empty($croquis))
                            <img src="{{ $croquis }}" alt="Croquis">
                        @else
                            <div style="padding-top: 80px; color: #999;">
                                <strong>CROQUIS / DIAGRAMA</strong>
                            </div>
                        @endif
                    </div>
                </td>

                <!-- Columna derecha: Tabla de dimensiones -->
                <td style="width: 60%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr class="bg-gray">
                            <th style="width: 8%;">COTA</th>
                            <th style="width: 18%;">VALOR TEÓRICO</th>
                            <th style="width: 15%;">TOLER.</th>
                            <th style="width: 18%;">VALOR REAL</th>
                            <th style="width: 18%;">DESVIACIÓN</th>
                            <th style="width: 23%;">RESULTADO</th>
                        </tr>
                        @foreach($dimensiones as $dim)
                        <tr>
                            <td class="text-center text-bold">{{ $dim['cota'] }}</td>
                            <td>{{ $dim['valor_teorico'] }}</td>
                            <td>{{ $dim['tolerancia'] }}</td>
                            <td>{{ $dim['valor_real'] }}</td>
                            <td>{{ $dim['desviacion'] }}</td>
                            <td>{{ $dim['resultado'] }}</td>
                        </tr>
                        @endforeach
                    </table>
                </td>
            </tr>
        </table>

        <!-- Tabla de acciones correctivas -->
        <table style="margin-bottom: 5px;">
            <tr class="bg-gray">
                <th colspan="3">ACCIONES CORRECTIVAS</th>
            </tr>
            <tr>
                <td style="width: 15%; background-color: #f0f0f0;"><strong>ACCIÓN A SEGUIR:</strong></td>
                <td style="width: 15%; background-color: #f0f0f0;"><strong>RESPONSABLE:</strong></td>
                <td style="width: 15%; background-color: #f0f0f0;"><strong>PLAZO:</strong></td>
            </tr>
            <tr>
                <td style="vertical-align: top; min-height: 40px;">{{ $accion_seguir }}</td>
                <td>{{ $responsable }}</td>
                <td>{{ $plazo }}</td>
            </tr>
        </table>

        <!-- Tabla de aprobado para -->
        <table style="margin-bottom: 5px;">
            <tr class="bg-gray">
                <th colspan="4">APROBADO PARA:</th>
            </tr>
            <tr>
                <td style="width: 25%; padding: 8px;">
                    <span class="checkbox {{ in_array('PINTURA', $aprobado_para) ? 'checked' : '' }}"></span>
                    <strong>PINTURA</strong>
                </td>
                <td style="width: 25%; padding: 8px;">
                    <span class="checkbox {{ in_array('CONTINUAR EL PROCESO', $aprobado_para) ? 'checked' : '' }}"></span>
                    <strong>CONTINUAR EL PROCESO</strong>
                </td>
                <td style="width: 25%; padding: 8px;">
                    <span class="checkbox {{ in_array('REPARACIÓN', $aprobado_para) ? 'checked' : '' }}"></span>
                    <strong>REPARACIÓN</strong>
                </td>
                <td style="width: 25%; padding: 8px;">
                    <span class="checkbox {{ in_array('ENTREGA FINAL', $aprobado_para) ? 'checked' : '' }}"></span>
                    <strong>ENTREGA FINAL</strong>
                </td>
            </tr>
        </table>

        <!-- Firmas -->
        <table>
            <tr>
                <td colspan="2">
                    @include('pdf.partials.firmas-section')
                </td>
            </tr>
        </table>
    </main>
</body>

</html>
