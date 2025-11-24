<!doctype html>
<html lang='es'>

<head>
    <title>Reporte de Inspección</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Use an absolute path when specifying the CSS so it works in the PDF --}}
    <link href='{{ public_path('css/reports/general.css') }}' rel='stylesheet'>
    <link href='{{ public_path('css/components/header.css') }}' rel='stylesheet'>
    <style>

        img {
            max-width: 600px;
            max-height: 300px;
        }
    </style>
</head>

<body>
   <header>
       <x-pdf.header></x-pdf.header>
   </header>

    <main>
        <x-pdf.table :report="$report"></x-pdf.table>

        <x-pdf.text-area style="margin-top: 40px" label="NOVEDADES PRESENTES (ANOMALY):">
            {!! $report->fieldReports[0]['value'] !!}
        </x-pdf.text-area>
        @if (isset($report->fieldReports[1]))
            <x-pdf.text-area label="ACCIÓN (ES) A SEGUIR Y/O ALTERNATIVAS DE SOLUCIÓN:">
                {!! $report->fieldReports[1]['value'] !!}
            </x-pdf.text-area>
        @endif

        <x-pdf.prepared-by :firma="'storage/' . $report->user->signature"></x-pdf.prepared-by>
    </main>

</body>

</html>
