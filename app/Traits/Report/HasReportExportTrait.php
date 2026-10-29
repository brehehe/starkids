<?php

namespace App\Traits\Report;

use App\Exports\GenericArrayExport;
use App\Models\Company\Company;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;

trait HasReportExportTrait
{
    /**
     * Export data to PDF format and stream directly to client.
     */
    protected function exportPDFResponse(
        string $filename,
        string $title,
        array $columns,
        array $rows,
        string $orientation = 'portrait',
        ?array $totals = null,
        ?string $period = null
    ): StreamedResponse {
        $user = Auth::user();
        $company = $user?->company ?? Company::with('companyDetail')->first();

        $cleanFilename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename).'_'.now()->format('Ymd_His').'.pdf';

        $pdf = Pdf::loadView('pdf.generic-report', [
            'company' => $company,
            'title' => $title,
            'columns' => $columns,
            'rows' => $rows,
            'totals' => $totals,
            'period' => $period,
            'generated_at' => now()->translatedFormat('d F Y H:i'),
            'user' => $user?->name ?? 'Admin',
        ])->setPaper('a4', $orientation);

        // Render DomPDF and embed page number footer
        $canvas = $pdf->getDomPDF()->getCanvas();
        $font = $pdf->getDomPDF()->getFontMetrics()->getFont('Helvetica', 'normal');

        if ($orientation === 'landscape') {
            $canvas->page_text(380, 565, 'Halaman {PAGE_NUM} dari {PAGE_COUNT}', $font, 8, [0.45, 0.45, 0.45]);
        } else {
            $canvas->page_text(260, 810, 'Halaman {PAGE_NUM} dari {PAGE_COUNT}', $font, 8, [0.45, 0.45, 0.45]);
        }

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, $cleanFilename, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Export data to Excel format and stream directly to client.
     */
    protected function exportExcelResponse(
        string $filename,
        array $headings,
        array $rows,
        string $sheetTitle = 'Laporan'
    ): StreamedResponse {
        $cleanFilename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $filename).'_'.now()->format('Ymd_His').'.xlsx';
        $export = new GenericArrayExport($headings, $rows, $sheetTitle);

        return response()->streamDownload(function () use ($export) {
            echo Excel::raw($export, \Maatwebsite\Excel\Excel::XLSX);
        }, $cleanFilename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }
}
