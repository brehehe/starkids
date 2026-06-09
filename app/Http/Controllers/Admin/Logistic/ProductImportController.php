<?php

namespace App\Http\Controllers\Admin\Logistic;

use App\Http\Controllers\Controller;
use App\Imports\ProductImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductImportController extends Controller
{
    /**
     * Display the import form
     */
    public function index()
    {
        return view('admin.logistic.product-import.index');
    }

    /**
     * Handle the Excel import
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx,xls|max:10240', // Max 10MB
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'File tidak valid',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('file');

            // Store the file temporarily
            $path = $file->store('temp/imports');

            // Create import instance
            $import = new ProductImport();

            // Execute import
            Excel::import($import, $path);

            // Get results
            $results = $import->getResults();

            // Clean up temporary file
            Storage::delete($path);

            return response()->json([
                'success' => true,
                'message' => 'Import berhasil!',
                'data' => [
                    'products_created' => $results['products_created'],
                    'products_updated' => $results['products_updated'],
                    'factories_created' => $results['factories_created'],
                    'factories_updated' => $results['factories_updated'],
                    'stock_operations' => $results['stock_operations'],
                    'price_operations' => $results['price_operations'],
                    'errors' => $results['errors']
                ]
            ]);
        } catch (\Exception $e) {
            // Clean up file if exists
            if (isset($path)) {
                Storage::delete($path);
            }

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat import: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download template Excel file
     */
    public function downloadTemplate()
    {
        $headers = [
            'name',
            'sku_number',
            'principle',
            'tipe_produk',
            'quantity',
            'hpp_average',
            'selling_price'
        ];

        $sampleData = [
            [
                'name' => 'Paracetamol 500mg',
                'sku_number' => 'PAR500',
                'principle' => 'Kimia Farma',
                'tipe_produk' => 'Obat',
                'quantity' => 100,
                'hpp_average' => 1500,
                'selling_price' => 2000
            ],
            [
                'name' => 'Amoxicillin 250mg',
                'sku_number' => 'AMX250',
                'principle' => 'Indofarma',
                'tipe_produk' => 'Obat',
                'quantity' => 50,
                'hpp_average' => 2500,
                'selling_price' => 3500
            ]
        ];

        // Create simple Excel export
        return Excel::download(new class($headers, $sampleData) implements \Maatwebsite\Excel\Concerns\FromArray {
            private $headers;
            private $data;

            public function __construct($headers, $data)
            {
                $this->headers = $headers;
                $this->data = $data;
            }

            public function array(): array
            {
                return array_merge([$this->headers], $this->data);
            }
        }, 'template_import_produk.xlsx');
    }

    /**
     * Get import status/progress (for future enhancement)
     */
    public function status($jobId = null)
    {
        // This can be enhanced with job queues for large files
        return response()->json([
            'status' => 'completed',
            'progress' => 100
        ]);
    }
}
