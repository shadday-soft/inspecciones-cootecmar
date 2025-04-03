@props(['firma'])
<div>
    <!-- It is not the man who has too little, but the man who craves more, that is poor. - Seneca -->
    <table>
        <td>
            <div style="padding: 0px 10px">
                <label for="" style="font-weight: bold; font-size: 12px">ELABORADO POR (Done by):</label>

                <div class="signature"
                    style="border-bottom: 1px solid black; width: 90%; margin-top: 10px; margin-left: 5%">
                    <img src="{{ $firma }}" alt="{{ $firma }}" style="width: 100%; height: 30%;">
                </div>
                <div style="margin-left: 40%; margin-bottom: 20px">(Firma)</div>
                <div style="margin-top: 10px"><strong>Nombre:</strong> Erick Jose Cantillo Jimenez</div>
                <div><strong>Cargo:</strong> Auxiliar de investigación y desarrollo</div>
            </div>
        </td>
        <td>
            <div style="padding: 0px 10px">
                <label for="" style="font-weight: bold; font-size: 12px">REVISADO Y AUTORIZADO POR (Authorized
                    by):</label>

                <div class="signature"
                    style="border-bottom: 1px solid black; width: 90%; margin-top: 10px; margin-left: 5%">
                    <img src="{{ $firma }}" alt="{{ $firma }}" style="width: 100%; height: 30%;">
                </div>
                <div style="margin-left: 40%; margin-bottom: 20px">(Firma)</div>
                <div style="margin-top: 10px"><strong>Nombre:</strong> Erick Jose Cantillo Jimenez</div>
                <div><strong>Cargo:</strong> Auxiliar de investigación y desarrollo</div>
            </div>
        </td>
    </table>
</div>
