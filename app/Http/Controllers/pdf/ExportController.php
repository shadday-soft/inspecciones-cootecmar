<?php

namespace App\Http\Controllers\pdf;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Barryvdh\DomPDF\Facade\Pdf;

class ExportController extends Controller
{
    public function export(Report $report)
    {

        $reporte = $report->load('user', 'fieldReports', 'inspection', 'inspection.project');
        $data = [
            'report' => $reporte,
        ];

        if ($report->type == 'REPORTE DE INSPECCIÓN DE HERMETICIDAD POR PRESIÓN') {
            $pdf = Pdf::loadView('pdf.reporte-hermeticidad-por-presion', $data);
        } elseif ($report->type == 'REPORTE DE INSPECCIÓN POR LÍQUIDOS PENETRANTES') {
            $pdf = Pdf::loadView('pdf.reporte-liquidos-penetrantes', $data);
        } elseif ($report->type == 'REPORTE DE INSPECCIÓN POR LÍQUIDOS PENETRANTES DETALLADO') {
            $pdf = Pdf::loadView('pdf.reporte-liquidos-penetrantes-detallado', $data);
        } elseif ($report->type == 'REPORTE DE INSPECCIÓN POR PARTÍCULAS MAGNÉTICAS') {
            $pdf = Pdf::loadView('pdf.reporte-particulas-magneticas', $data);
        } elseif ($report->type == 'REPORTE DE INSPECCIÓN POR ULTRASONIDO') {
            $pdf = Pdf::loadView('pdf.reporte-ultrasonido', $data);
        } elseif ($report->type == 'CONTROL DIMENSIONAL') {
            $pdf = Pdf::loadView('pdf.reporte-control-dimensional', $data);
        } elseif ($report->type == 'PRUEBA DE ADHERENCIA') {
            $pdf = Pdf::loadView('pdf.reporte-prueba-adherencia', $data);
        } else {
            $pdf = Pdf::loadView('pdf.reporte-inspeccion', $data);
        }

        // Option 1) Show the PDF in the browser
        return $pdf->stream();
    }
}
