<div>
    <table>
        <td>GERENCIA (MANAGEMENT): {{ $report->inspection->gerencia }}</td>
        <td>DEPENDENCIA (WORKSHOP):</td>
    </table>
    <table>
        <td>Fecha: {{ $report->inspection->fecha }}</td>
        <td>Proyecto: {{ $report->inspection->project->name }}</td>
    </table>
    <table>
        <td>Actividades: {{ $report->inspection->descripcion }}</td>
        <td>GRAFO: {{ $report->inspection->grafo }}</td>
        <td>REGISTRO No (REGISTER): </td>
    </table>
</div>
