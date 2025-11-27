<!doctype html>
<html lang='es'>

<head>
    <title>Prueba de Adherencia</title>
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
        @include('pdf.headers.prueba-adherencia-header')
    </header>

    <main>
        @php
            $informe_no = collect($report->fieldReports)->firstWhere('field', 'informe_no')['value'] ?? '';
            $planta = collect($report->fieldReports)->firstWhere('field', 'planta')['value'] ?? '';
            $fecha = collect($report->fieldReports)->firstWhere('field', 'fecha')['value'] ?? '';
            $qt_p = collect($report->fieldReports)->firstWhere('field', 'qt_p')['value'] ?? '';
            $proyecto = collect($report->fieldReports)->firstWhere('field', 'proyecto')['value'] ?? '';
            $fecha_prueba = collect($report->fieldReports)->firstWhere('field', 'fecha_prueba')['value'] ?? '';
            
            $cuadricula = collect($report->fieldReports)->firstWhere('field', 'cuadricula')['value'] ?? false;
            $metodo_hidraulico = collect($report->fieldReports)->firstWhere('field', 'metodo_hidraulico')['value'] ?? false;
            $corte_en_x = collect($report->fieldReports)->firstWhere('field', 'corte_en_x')['value'] ?? false;
            
            $equipo = collect($report->fieldReports)->firstWhere('field', 'equipo')['value'] ?? '';
            $modelo = collect($report->fieldReports)->firstWhere('field', 'modelo')['value'] ?? '';
            $marca = collect($report->fieldReports)->firstWhere('field', 'marca')['value'] ?? '';
            $rango_trabajo = collect($report->fieldReports)->firstWhere('field', 'rango_trabajo')['value'] ?? '';
            $serie = collect($report->fieldReports)->firstWhere('field', 'serie')['value'] ?? '';
            $codigo_metrologico = collect($report->fieldReports)->firstWhere('field', 'codigo_metrologico')['value'] ?? '';
            
            $temperatura_sustrato = collect($report->fieldReports)->firstWhere('field', 'temperatura_sustrato')['value'] ?? '';
            $temperatura_ambiental = collect($report->fieldReports)->firstWhere('field', 'temperatura_ambiental')['value'] ?? '';
            $humedad_relativa = collect($report->fieldReports)->firstWhere('field', 'humedad_relativa')['value'] ?? '';
            $punto_rocio = collect($report->fieldReports)->firstWhere('field', 'punto_rocio')['value'] ?? '';
            
            $adhesivo_utilizado = collect($report->fieldReports)->firstWhere('field', 'adhesivo_utilizado')['value'] ?? '';
            $metodo_prueba = collect($report->fieldReports)->firstWhere('field', 'metodo_prueba')['value'] ?? '';
            $localizacion_prueba = collect($report->fieldReports)->firstWhere('field', 'localizacion_prueba')['value'] ?? '';
            $valor_prueba = collect($report->fieldReports)->firstWhere('field', 'valor_prueba')['value'] ?? '';
            $numero_recubrimientos = collect($report->fieldReports)->firstWhere('field', 'numero_recubrimientos')['value'] ?? '';
            $duracion_prueba = collect($report->fieldReports)->firstWhere('field', 'duracion_prueba')['value'] ?? '';
            $clase_recubrimiento = collect($report->fieldReports)->firstWhere('field', 'clase_recubrimiento')['value'] ?? '';
            $espesor_promedio = collect($report->fieldReports)->firstWhere('field', 'espesor_promedio')['value'] ?? '';
            $perfil_anclaje = collect($report->fieldReports)->firstWhere('field', 'perfil_anclaje')['value'] ?? '';
            
            $observaciones = collect($report->fieldReports)->firstWhere('field', 'observaciones')['value'] ?? '';
            
            // Extraer resultados
            $resultados = [];
            for ($i = 1; $i <= 3; $i++) {
                $resultados[] = [
                    'numero' => $i,
                    'espesor_seco' => collect($report->fieldReports)->firstWhere('field', "resultado_{$i}_espesor_seco")['value'] ?? '',
                    'dato_inicial' => collect($report->fieldReports)->firstWhere('field', "resultado_{$i}_dato_inicial")['value'] ?? '',
                    'dato_final' => collect($report->fieldReports)->firstWhere('field', "resultado_{$i}_dato_final")['value'] ?? '',
                    'resultado_psi' => collect($report->fieldReports)->firstWhere('field', "resultado_{$i}_resultado_psi")['value'] ?? '',
                    'porcentaje_adheridos' => collect($report->fieldReports)->firstWhere('field', "resultado_{$i}_porcentaje_adheridos")['value'] ?? '',
                    'falla' => collect($report->fieldReports)->firstWhere('field', "resultado_{$i}_falla")['value'] ?? '',
                    'observaciones' => collect($report->fieldReports)->firstWhere('field', "resultado_{$i}_observaciones")['value'] ?? '',
                ];
            }

            $realizado_nombre = collect($report->fieldReports)->firstWhere('field', 'realizado_nombre')['value'] ?? '';
            $realizado_firma = collect($report->fieldReports)->firstWhere('field', 'realizado_firma')['value'] ?? null;
            $reviso_nombre = collect($report->fieldReports)->firstWhere('field', 'reviso_nombre')['value'] ?? '';
            $reviso_firma = collect($report->fieldReports)->firstWhere('field', 'reviso_firma')['value'] ?? null;
            $autorizo_nombre = collect($report->fieldReports)->firstWhere('field', 'autorizo_nombre')['value'] ?? '';
            $autorizo_firma = collect($report->fieldReports)->firstWhere('field', 'autorizo_firma')['value'] ?? null;
        @endphp

        <!-- Tabla de información general -->
        <table style="margin-bottom: 5px;">
            <tr>
                <td style="width: 15%; background-color: #f0f0f0;"><strong>INFORME N°:</strong></td>
                <td style="width: 35%;">{{ $informe_no }}</td>
                <td style="width: 15%; background-color: #f0f0f0;"><strong>FECHA:</strong></td>
                <td style="width: 35%;">{{ $fecha }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>PLANTA:</strong></td>
                <td>{{ $planta }}</td>
                <td style="background-color: #f0f0f0;"><strong>Q.T/P°:</strong></td>
                <td>{{ $qt_p }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>PROYECTO:</strong></td>
                <td>{{ $proyecto }}</td>
                <td style="background-color: #f0f0f0;"><strong>FECHA PRUEBA:</strong></td>
                <td>{{ $fecha_prueba }}</td>
            </tr>
        </table>

        <!-- Sección I: Método Utilizado -->
        <table style="margin-bottom: 5px;">
            <tr>
                <th colspan="3" class="bg-gray">I. MÉTODO UTILIZADO</th>
            </tr>
            <tr>
                <td style="width: 33%; padding: 8px;">
                    <span class="checkbox {{ $cuadricula ? 'checked' : '' }}"></span>
                    <strong>A. CUADRÍCULA</strong>
                </td>
                <td style="width: 34%; padding: 8px;">
                    <span class="checkbox {{ $metodo_hidraulico ? 'checked' : '' }}"></span>
                    <strong>B. MÉTODO HIDRÁULICO</strong>
                </td>
                <td style="width: 33%; padding: 8px;">
                    <span class="checkbox {{ $corte_en_x ? 'checked' : '' }}"></span>
                    <strong>C. CORTE EN X</strong>
                </td>
            </tr>
        </table>

        <!-- Información del equipo -->
        <table style="margin-bottom: 5px;">
            <tr>
                <td style="width: 16%; background-color: #f0f0f0;"><strong>EQUIPO:</strong></td>
                <td style="width: 17%;">{{ $equipo }}</td>
                <td style="width: 17%; background-color: #f0f0f0;"><strong>MODELO:</strong></td>
                <td style="width: 17%;">{{ $modelo }}</td>
                <td style="width: 16%; background-color: #f0f0f0;"><strong>MARCA:</strong></td>
                <td style="width: 17%;">{{ $marca }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>RANGO DE TRABAJO:</strong></td>
                <td>{{ $rango_trabajo }}</td>
                <td style="background-color: #f0f0f0;"><strong>SERIE:</strong></td>
                <td>{{ $serie }}</td>
                <td style="background-color: #f0f0f0;"><strong>CÓDIGO METROLÓGICO:</strong></td>
                <td>{{ $codigo_metrologico }}</td>
            </tr>
        </table>

        <!-- Sección II: Condiciones Ambientales -->
        <table style="margin-bottom: 5px;">
            <tr>
                <th colspan="4" class="bg-gray">II. CONDICIONES AMBIENTALES</th>
            </tr>
            <tr>
                <td style="width: 25%; background-color: #f0f0f0;"><strong>Temperatura del sustrato °C:</strong></td>
                <td style="width: 25%;">{{ $temperatura_sustrato }}</td>
                <td style="width: 25%; background-color: #f0f0f0;"><strong>Temperatura ambiental °C:</strong></td>
                <td style="width: 25%;">{{ $temperatura_ambiental }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>Humedad relativa %:</strong></td>
                <td>{{ $humedad_relativa }}</td>
                <td style="background-color: #f0f0f0;"><strong>Punto de rocío °C:</strong></td>
                <td>{{ $punto_rocio }}</td>
            </tr>
        </table>

        <!-- Sección III: Detalle del Sistema -->
        <table style="margin-bottom: 5px;">
            <tr>
                <th colspan="4" class="bg-gray">III. DETALLE DEL SISTEMA</th>
            </tr>
            <tr>
                <td style="width: 25%; background-color: #f0f0f0;"><strong>ADHESIVO UTILIZADO:</strong></td>
                <td style="width: 25%;">{{ $adhesivo_utilizado }}</td>
                <td style="width: 25%; background-color: #f0f0f0;"><strong>MÉTODO DE LA PRUEBA:</strong></td>
                <td style="width: 25%;">
                    <span class="checkbox {{ $metodo_prueba == 'Destructivo' ? 'checked' : '' }}"></span> Destructivo
                    <span class="checkbox {{ $metodo_prueba == 'No Destructivo' ? 'checked' : '' }}"></span> No Destructivo
                </td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>LOCALIZACIÓN DE LA PRUEBA:</strong></td>
                <td>{{ $localizacion_prueba }}</td>
                <td style="background-color: #f0f0f0;"><strong>VALOR DE LA PRUEBA:</strong></td>
                <td>{{ $valor_prueba }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>N° DE RECUBRIMIENTOS:</strong></td>
                <td>{{ $numero_recubrimientos }}</td>
                <td style="background-color: #f0f0f0;"><strong>DURACIÓN DE LA PRUEBA:</strong></td>
                <td>{{ $duracion_prueba }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>CLASE DE RECUBRIMIENTO:</strong></td>
                <td>{{ $clase_recubrimiento }}</td>
                <td style="background-color: #f0f0f0;"><strong>ESPESOR PROMEDIO:</strong></td>
                <td>{{ $espesor_promedio }}</td>
            </tr>
            <tr>
                <td style="background-color: #f0f0f0;"><strong>PERFIL DE ANCLAJE (MILS):</strong></td>
                <td colspan="3">{{ $perfil_anclaje }}</td>
            </tr>
        </table>

        <!-- Sección IV: Resultados -->
        <table style="margin-bottom: 5px;">
            <tr>
                <th colspan="8" class="bg-gray">IV. RESULTADOS</th>
            </tr>
            <tr class="bg-gray">
                <th style="width: 5%;">N°</th>
                <th style="width: 12%;">Espesor seco mils</th>
                <th style="width: 12%;">Dato inicial</th>
                <th style="width: 12%;">Dato final</th>
                <th style="width: 12%;">Resultado psi</th>
                <th style="width: 15%;">Porcentaje de adheridos</th>
                <th style="width: 12%;">Falla</th>
                <th style="width: 20%;">Observaciones</th>
            </tr>
            @foreach($resultados as $resultado)
            <tr>
                <td class="text-center text-bold">{{ $resultado['numero'] }}</td>
                <td>{{ $resultado['espesor_seco'] }}</td>
                <td>{{ $resultado['dato_inicial'] }}</td>
                <td>{{ $resultado['dato_final'] }}</td>
                <td>{{ $resultado['resultado_psi'] }}</td>
                <td>{{ $resultado['porcentaje_adheridos'] }}</td>
                <td>{{ $resultado['falla'] }}</td>
                <td>{{ $resultado['observaciones'] }}</td>
            </tr>
            @endforeach
        </table>

        <!-- Sección V: Observaciones -->
        <table style="margin-bottom: 5px;">
            <tr>
                <th class="bg-gray">V. OBSERVACIONES:</th>
            </tr>
            <tr>
                <td style="min-height: 60px; vertical-align: top; padding: 8px;">{{ $observaciones }}</td>
            </tr>
        </table>

        <!-- Firmas (3 columnas) -->
        <table>
            <tr>
                <td style="width: 33%; text-align: center; vertical-align: top; padding: 10px;">
                    <div style="margin-bottom: 5px;"><strong>Realizado:</strong></div>
                    <div style="border-bottom: 2px solid #000; min-height: 50px; margin: 10px 0; text-align: center;">
                        @if(!empty($realizado_firma))
                            <img src="{{ $realizado_firma }}" alt="Firma" style="max-width: 150px; max-height: 40px; object-fit: contain;">
                        @endif
                    </div>
                    <div style="margin-top: 3px; font-size: 8px;">(FIRMA)</div>
                    <div style="margin-top: 8px;"><strong>NOMBRE:</strong></div>
                    <div>{{ $realizado_nombre }}</div>
                </td>
                <td style="width: 34%; text-align: center; vertical-align: top; padding: 10px;">
                    <div style="margin-bottom: 5px;"><strong>Revisó:</strong></div>
                    <div style="border-bottom: 2px solid #000; min-height: 50px; margin: 10px 0; text-align: center;">
                        @if(!empty($reviso_firma))
                            <img src="{{ $reviso_firma }}" alt="Firma" style="max-width: 150px; max-height: 40px; object-fit: contain;">
                        @endif
                    </div>
                    <div style="margin-top: 3px; font-size: 8px;">(FIRMA)</div>
                    <div style="margin-top: 8px;"><strong>NOMBRE:</strong></div>
                    <div>{{ $reviso_nombre }}</div>
                </td>
                <td style="width: 33%; text-align: center; vertical-align: top; padding: 10px;">
                    <div style="margin-bottom: 5px;"><strong>Autorizó:</strong></div>
                    <div style="border-bottom: 2px solid #000; min-height: 50px; margin: 10px 0; text-align: center;">
                        @if(!empty($autorizo_firma))
                            <img src="{{ $autorizo_firma }}" alt="Firma" style="max-width: 150px; max-height: 40px; object-fit: contain;">
                        @endif
                    </div>
                    <div style="margin-top: 3px; font-size: 8px;">(FIRMA)</div>
                    <div style="margin-top: 8px;"><strong>NOMBRE:</strong></div>
                    <div>{{ $autorizo_nombre }}</div>
                </td>
            </tr>
        </table>
    </main>
</body>

</html>
