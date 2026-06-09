<?php

namespace App\Http\Controllers\Admin\Logistic\ReplaceProduct;

use App\Http\Controllers\Controller;
use App\Imports\ReplaceProductImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;
use Exception;

class ReplaceProductImportController extends Controller
{
    /**
     * Import replace product data from Excel file
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function import(Request $request)
    {
        try {
            // Validate the uploaded file
            $request->validate([
                'import' => 'required|file|mimes:xlsx,xls|max:10240', // Max 10MB
            ]);

            $file = $request->file('import');

            // Log the import attempt
            Log::info('Replace Product Import started', [
                'file_name' => $file->getClientOriginalName(),
                'file_size' => $file->getSize(),
                'user_id' => auth()->id(),
            ]);

            // Process the import
            $import = new ReplaceProductImport();
            Excel::import($import, $file);

            // Get import results
            $results = $import->getResults();

            // Log successful import
            Log::info('Replace Product Import completed successfully', [
                'results' => $results,
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Import berhasil!',
                'data' => $results
            ]);
        } catch (Exception $e) {
            // Log the error
            Log::error('Replace Product Import failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Import gagal: ' . $e->getMessage(),
                'error' => $e->getMessage()
            ], 422);
        }
    }

    /**
     * Download template for replace product import
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function downloadTemplate()
    {
        try {
            $templatePath = storage_path('app/templates/replace_product_template.xlsx');

            if (!file_exists($templatePath)) {
                // Create template if not exists
                $this->createTemplate();
            }

            return response()->download($templatePath, 'template_replace_product.xlsx');
        } catch (Exception $e) {
            Log::error('Failed to download replace product template', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return back()->with('error', 'Gagal mengunduh template: ' . $e->getMessage());
        }
    }

    /**
     * Create Excel template for replace product import
     *
     * @return void
     */
    private function createTemplate()
    {
        // Sample data for template
        $headers = [
            'SKU Number',
            'Product Name',
            'Old Stock',
            'New Stock',
            'Reason',
            'Notes',
            'Principle',
            'Unit',
            'Category'
        ];

        $sampleData = [
            [
                'SKU001',
                'Paracetamol 500mg',
                '100',
                '120',
                'Stock Opname',
                'Hasil perhitungan fisik',
                'Kimia Farma',
                'Strip',
                'Obat'
            ],
            [
                'SKU002',
                'Amoxicillin 250mg',
                '50',
                '45',
                'Expired',
                'Beberapa unit sudah expired',
                'Dexa Medica',
                'Botol',
                'Obat'
            ]
        ];

        // Create Excel file with PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set headers
        $column = 'A';
        foreach ($headers as $header) {
            $sheet->setCellValue($column . '1', $header);
            $sheet->getStyle($column . '1')->getFont()->setBold(true);
            $sheet->getColumnDimension($column)->setAutoSize(true);
            $column++;
        }

        // Set sample data
        $row = 2;
        foreach ($sampleData as $data) {
            $column = 'A';
            foreach ($data as $value) {
                $sheet->setCellValue($column . $row, $value);
                $column++;
            }
            $row++;
        }

        // Save template
        $templateDir = storage_path('app/templates');
        if (!is_dir($templateDir)) {
            mkdir($templateDir, 0755, true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save(storage_path('app/templates/replace_product_template.xlsx'));
    }

    /**
     * Get import history
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getImportHistory(Request $request)
    {
        try {
            // You can implement import history tracking here
            // For now, return empty array
            return response()->json([
                'success' => true,
                'data' => [],
                'message' => 'Import history retrieved successfully'
            ]);
        } catch (Exception $e) {
            Log::error('Failed to get import history', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil riwayat import: ' . $e->getMessage()
            ], 500);
        }
    }
}
