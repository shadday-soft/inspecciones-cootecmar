<!-- Firmas -->
<table style="margin-top: 30px; width: 100%;">
    <tr>
        <td style="width: 50%; padding-right: 10px; vertical-align: top;">
            <div style="border: 2px solid #000; padding: 10px;">
                <div style="font-weight: bold; margin-bottom: 5px;">ELABORADO POR (Done by):</div>
                @if(!empty($elaborado_por_firma))
                    <div style="text-align: center; margin: 10px 0;">
                        <img src="{{ $elaborado_por_firma }}" alt="Firma" style="max-width: 150px; height: auto;">
                    </div>
                @endif
                <div style="border-top: 2px solid #000; padding-top: 5px; margin-top: 10px;">
                    <div style="margin-bottom: 3px;"><strong>NOMBRE:</strong> {{ $elaborado_por_nombre ?? '' }}</div>
                    <div><strong>CARGO:</strong> {{ $elaborado_por_cargo ?? '' }}</div>
                </div>
                <div style="text-align: center; margin-top: 10px; font-style: italic; font-size: 8px;">(FIRMA)</div>
            </div>
        </td>
        <td style="width: 50%; padding-left: 10px; vertical-align: top;">
            <div style="border: 2px solid #000; padding: 10px;">
                <div style="font-weight: bold; margin-bottom: 5px;">REVISADO Y AUTORIZADO POR (Authorized by):</div>
                @if(!empty($revisado_por_firma))
                    <div style="text-align: center; margin: 10px 0;">
                        <img src="{{ $revisado_por_firma }}" alt="Firma" style="max-width: 150px; height: auto;">
                    </div>
                @endif
                <div style="border-top: 2px solid #000; padding-top: 5px; margin-top: 10px;">
                    <div style="margin-bottom: 3px;"><strong>NOMBRE:</strong> {{ $revisado_por_nombre ?? '' }}</div>
                    <div><strong>CARGO:</strong> {{ $revisado_por_cargo ?? '' }}</div>
                </div>
                <div style="text-align: center; margin-top: 10px; font-style: italic; font-size: 8px;">(FIRMA)</div>
            </div>
        </td>
    </tr>
</table>
