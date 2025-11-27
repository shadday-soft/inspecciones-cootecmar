<table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
    <tr>
        <td rowspan="2" style="width: 20%; text-align: center; padding: 5px; border: 2px solid #000;">
            <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="max-width: 100px; height: auto;">
        </td>
        <td style="width: 60%; text-align: center; padding: 5px; border: 2px solid #000; border-left: none; font-weight: bold; font-size: 11px;">
            REPORTE DE INSPECCIÓN POR PARTÍCULAS MAGNÉTICAS
        </td>
        <td style="width: 20%; text-align: left; padding: 5px; border: 2px solid #000; border-left: none; font-size: 9px;">
            <strong>Código:</strong> F-COPSER-010<br>
            <strong>Versión:</strong> 7
        </td>
    </tr>
    <tr>
        <td style="text-align: center; padding: 5px; border: 2px solid #000; border-left: none; border-top: none; font-size: 9px;">
            <strong>COTECMAR</strong>
        </td>
        <td style="text-align: left; padding: 5px; border: 2px solid #000; border-left: none; border-top: none; font-size: 9px;">
            <strong>Fecha:</strong> {{ $date ?? date('d/m/Y') }}
        </td>
    </tr>
</table>
