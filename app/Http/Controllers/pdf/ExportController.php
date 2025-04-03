<?php

namespace App\Http\Controllers\pdf;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export (Report $report){

        $reporte = $report->load('user', 'fieldReports');
        $data = [
            'report' => $reporte,
            'to' => 'Sam Example',
            'subtotal' => '5.00',
            'tax' => '.35',
            'total' => '5.35'
        ];

        $pdf = Pdf::loadView('pdf.reporte-inspeccion', $data);

        # Option 1) Show the PDF in the browser
        return $pdf->stream();
    }
}
