<?php

namespace App\Http\Controllers\pdf;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function export (Report $report){

        $reporte = $report->load('user', 'fieldReports', 'inspection', 'inspection.project');
        $data = [
            'report' => $reporte,
        ];

        if($report->type == 'REPORTE DE INSPECCIÓN DE HERMETICIDAD POR PRESIÓN'){
            $pdf = Pdf::loadView('pdf.reporte-hermeticidad-por-presion', $data);
        }else{
            $pdf = Pdf::loadView('pdf.reporte-inspeccion', $data);
        }

        # Option 1) Show the PDF in the browser
        return $pdf->stream();
    }
}
