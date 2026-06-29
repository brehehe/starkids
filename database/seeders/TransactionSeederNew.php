<?php

namespace Database\Seeders;

use App\Helpers\RoleHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductType;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionDetail;
use App\Models\Transaction\TransactionPayment;
use App\Models\Transaction\TransactionProduct;
use App\Models\Unit\Unit;
use App\Models\User;
use App\Models\User\UserType;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * TransactionSeederNew - Seeder untuk update/create transaksi dari CSV
 *
 * Seeder ini akan:
 * 1. Membaca data dari CSV file transaction_new.csv dan transaction detail_new.csv
 * 2. Skip transaksi yang sudah ada berdasarkan code
 * 3. Membuat transaksi baru jika belum ada
 * 4. Update data terkait (TransactionDetail, TransactionPayment, TransactionProduct)
 *
 * Cara menjalankan:
 * php artisan db:seed --class=TransactionSeederNew
 */
class TransactionSeederNew extends Seeder
{
    use WithoutModelEvents;

    private const BATCH_SIZE = 50;

    // Cache untuk data yang sering digunakan
    private $company;

    private $branch;

    private $adminUser;

    private $paymentMethods = [];

    private $productType;

    private $productUnit;

    private $existingProducts = [];

    private $existingTransactions = [];

    private $processedUsers = [];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('=== TransactionSeederNew - Smart Transaction Import ===');

        // Initialize cache
        $this->initializeCache();

        // Parse CSV files
        $transactionCsvPath = __DIR__.'/csvs/transaction_new.csv';
        $transactionDetailCsvPath = __DIR__.'/csvs/transaction_detail_new.csv';

        if (! file_exists($transactionCsvPath) || ! file_exists($transactionDetailCsvPath)) {
            $this->command->error('CSV files not found!');

            return;
        }

        $transactionData = $this->parseCSV($transactionCsvPath);
        $transactionDetailData = $this->parseCSV($transactionDetailCsvPath);

        // Group details by code_kwintasi for faster lookup
        $groupedDetails = [];
        foreach ($transactionDetailData as $detail) {
            $groupedDetails[$detail['code_kwintasi']][] = $detail;
        }

        $totalTransactions = count($transactionData);
        $this->command->info("Processing {$totalTransactions} transactions...");

        $createdCount = 0;
        $skippedCount = 0;

        // Process in batches
        $batches = array_chunk($transactionData, self::BATCH_SIZE);

        foreach ($batches as $batchIndex => $batch) {
            $result = $this->processBatch($batch, $groupedDetails, $batchIndex + 1, count($batches));
            $createdCount += $result['created'];
            $skippedCount += $result['skipped'];
        }

        $this->command->info('=== Transaction Import Completed ===');
        $this->command->info("✅ Created: {$createdCount} transactions");
        $this->command->info("⚠️  Skipped (already exists): {$skippedCount} transactions");

        if ($skippedCount > 0) {
            $this->command->warn("Note: {$skippedCount} transactions were skipped because they already exist.");
            $this->command->warn("This seeder only creates new transactions, it doesn't update existing ones.");
        }
    }

    /**
     * Initialize cache for frequently used data
     */
    private function initializeCache()
    {
        $this->company = Company::first();
        $this->branch = Branch::where('company_id', $this->company->id)->first();
        $this->adminUser = User::where('company_id', $this->company->id)->first();

        if (! $this->company || ! $this->branch || ! $this->adminUser) {
            throw new Exception('Company, Branch, or Admin User not found. Please ensure you have basic data setup.');
        }

        // Cache payment methods
        PaymentMethod::where('company_id', $this->company->id)
            ->whereIn('name', ['Tunai', 'Kartu Debit'])
            ->get()
            ->each(function ($method) {
                $this->paymentMethods[$method->name] = $method->id;
            });

        // Cache product type dan unit
        $this->productType = ProductType::where('name', 'Jasa')->first();
        $this->productUnit = Unit::where('name', 'Pcs')->first();

        // Cache existing products
        Product::where('company_id', $this->company->id)
            ->get(['id', 'name'])
            ->each(function ($product) {
                $this->existingProducts[$product->name] = $product->id;
            });

        // Cache existing transactions
        Transaction::where('company_id', $this->company->id)
            ->pluck('id', 'code')
            ->each(function ($id, $code) {
                $this->existingTransactions[$code] = $id;
            });

        $this->command->info('📦 Cache initialized');
        $this->command->info('  - Products: '.count($this->existingProducts));
        $this->command->info('  - Existing Transactions: '.count($this->existingTransactions));
        $this->command->info('  - Payment Methods: '.count($this->paymentMethods));
    }

    /**
     * Process a batch of transactions
     */
    private function processBatch($batch, $groupedDetails, $batchNumber, $totalBatches)
    {
        $createdCount = 0;
        $skippedCount = 0;

        foreach ($batch as $row) {
            $result = $this->processTransaction($row, $groupedDetails);
            if ($result === 'created') {
                $createdCount++;
            } else {
                $skippedCount++;
            }
        }

        $this->command->info("📋 Batch {$batchNumber}/{$totalBatches} completed - Created: {$createdCount}, Skipped: {$skippedCount}");

        return [
            'created' => $createdCount,
            'skipped' => $skippedCount,
        ];
    }

    /**
     * Process single transaction - only create if doesn't exist
     */
    private function processTransaction($row, $groupedDetails)
    {
        $code = trim($row['code'] ?? '');

        // Skip if transaction already exists
        if (isset($this->existingTransactions[$code])) {
            return 'skipped';
        }

        DB::beginTransaction();

        try {
            // Process user
            $userId = $this->processUser($row);

            // Calculate totals from details
            $totalProductPrice = 0;
            if (isset($groupedDetails[$code])) {
                foreach ($groupedDetails[$code] as $detail) {
                    $totalProductPrice += (float) str_replace(',', '.', $detail['sub_total']);
                }
            }

            // Convert and parse values
            $cash = (float) str_replace(',', '.', $row['cash'] ?? '0');
            $debit = (float) str_replace(',', '.', $row['debit'] ?? '0');
            $paymentAmount = $cash + $debit;

            // Create transaction
            $transactionId = Str::uuid();
            $dateFormatted = $this->convertDateFormat($row['date']);
            $currentOrder = Transaction::max('order') + 1;

            $transactionData = [
                'id' => $transactionId,
                'code' => $code,
                'doctor_id' => null,
                'doctor_name' => null,
                'location_id' => null,
                'location_name' => null,
                'date' => $dateFormatted,
                'patient_id' => $userId,
                'patient_name' => $row['patient_name'],
                'patient_company_role_id' => null,
                'type_customer' => 'new',
                'branch_id' => $this->branch->id,
                'product_price' => $totalProductPrice,
                'sub_total_price_embalage' => $totalProductPrice,
                'sub_total_price' => $totalProductPrice,
                'discount_id' => null,
                'discount_real' => 0,
                'discount' => 0,
                'grand_total_price' => $totalProductPrice,
                'payment_amount' => $paymentAmount,
                'payment_change' => $paymentAmount - $totalProductPrice,
                'remaining_bill' => 0,
                'pharmacy_id' => null,
                'pharmacy_name' => null,
                'cashier_id' => $this->adminUser->id,
                'cashier_name' => $this->adminUser->name,
                'company_id' => $this->company->id,
                'created_by' => $this->adminUser->id,
                'status' => 'completed',
                'type' => 'non-resep',
                'order' => $currentOrder,
                'created_at' => $dateFormatted.' 00:00:00',
                'updated_at' => $dateFormatted.' 00:00:00',
            ];

            Transaction::create($transactionData);

            // Create payment records
            $this->createPayments($transactionId, $cash, $debit);

            // Create transaction details and products
            if (isset($groupedDetails[$code])) {
                $this->createTransactionDetails($transactionId, $groupedDetails[$code], $dateFormatted);
            }

            // Add to cache
            $this->existingTransactions[$code] = $transactionId;

            DB::commit();

            return 'created';
        } catch (Exception $e) {
            DB::rollback();
            $this->command->error("❌ Error creating transaction {$code}: ".$e->getMessage());

            return 'skipped';
        }
    }

    /**
     * Process user with caching to avoid duplicates
     */
    private function processUser($row)
    {
        $patientName = $row['patient_name'];

        // Check cache first
        if (isset($this->processedUsers[$patientName])) {
            return $this->processedUsers[$patientName];
        }

        // Check if user already exists in database
        $existingUser = User::where('name', $patientName)->first();
        if ($existingUser) {
            $this->processedUsers[$patientName] = $existingUser->id;

            return $existingUser->id;
        }

        // Create new user
        $name = strtolower(str_replace(' ', '', $patientName));
        $username = $name.uniqid();
        $userId = Str::uuid();

        $userData = [
            'id' => $userId,
            'name' => $patientName,
            'username' => $username,
            'email' => $username.'@example.com',
            'password' => Hash::make('12345678'),
            'company_id' => $this->company->id,
            'type_user' => 'patient',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'user_type_id' => UserType::where('name', 'Umum')->first()->id,
        ];

        $user = User::create($userData);
        $user->syncRoles('Pasien');
        RoleHelper::assignRoleToUserInCompany($user, 'Pasien', $this->company->id, null, false, true);

        $this->processedUsers[$patientName] = $user->id;

        return $user->id;
    }

    /**
     * Create payment records
     */
    private function createPayments($transactionId, $cash, $debit)
    {
        if ($cash > 0 && isset($this->paymentMethods['Tunai'])) {
            TransactionPayment::create([
                'transaction_id' => $transactionId,
                'payment_method_id' => $this->paymentMethods['Tunai'],
                'payment_amount' => $cash,
                'company_id' => $this->company->id,
            ]);
        }

        if ($debit > 0 && isset($this->paymentMethods['Kartu Debit'])) {
            TransactionPayment::create([
                'transaction_id' => $transactionId,
                'payment_method_id' => $this->paymentMethods['Kartu Debit'],
                'payment_amount' => $debit,
                'company_id' => $this->company->id,
            ]);
        }
    }

    /**
     * Create transaction details and products
     */
    private function createTransactionDetails($transactionId, $details, $dateFormatted)
    {
        foreach ($details as $detail) {
            $productId = $this->getOrCreateProduct($detail);
            $quantity = (int) $detail['Qty'];
            $price = (float) str_replace(',', '.', $detail['price']);
            $subTotal = (float) str_replace(',', '.', $detail['sub_total']);

            $hppPrice = $this->getHppPrice($productId);

            $detailData = [
                'transaction_id' => $transactionId,
                'product_id' => $productId,
                'name' => $detail['keterangan'],
                'quantity' => $quantity,
                'price' => $price,
                'sub_total_price' => $subTotal,
                'price_hpp' => $hppPrice,
                'sub_total_price_hpp' => $hppPrice * $quantity,
                'type_transaction' => 'medicine',
                'company_id' => $this->company->id,
                'created_at' => $dateFormatted.' 00:00:00',
                'updated_at' => $dateFormatted.' 00:00:00',
            ];

            $transactionDetail = TransactionDetail::create($detailData);

            // Create transaction product
            TransactionProduct::create([
                'transaction_id' => $transactionId,
                'transaction_detail_id' => $transactionDetail->id,
                'product_id' => $productId,
                'product_name' => $detail['keterangan'],
                'quantity' => $quantity,
                'price' => $price,
                'total' => $subTotal,
                'hpp_average' => 0,
                'hpp_total' => 0,
                'profit' => $subTotal,
                'margin' => 100,
                'company_id' => $this->company->id,
                'created_at' => $dateFormatted.' 00:00:00',
                'updated_at' => $dateFormatted.' 00:00:00',
            ]);

            // Update or create product price
            ProductPrice::updateOrCreate(
                [
                    'branch_id' => $this->branch->id,
                    'product_id' => $productId,
                    'company_id' => $this->company->id,
                ],
                [
                    'hpp_average' => 0,
                    'price' => $price,
                    'is_updated' => true,
                    'updated_at' => Carbon::now(),
                ]
            );
        }
    }

    /**
     * Get or create product
     */
    private function getOrCreateProduct($detail)
    {
        $productName = $detail['keterangan'];

        // Check existing products cache
        if (isset($this->existingProducts[$productName])) {
            return $this->existingProducts[$productName];
        }

        // Create new product
        $productData = [
            'name' => $productName,
            'company_id' => $this->company->id,
            'numerator_value' => 0,
            'medicine_dosage' => 0,
            'product_type_id' => $this->productType ? $this->productType->id : null,
            'unit_id' => $this->productUnit ? $this->productUnit->id : null,
            'is_non_stock' => 1,
            'normal' => 0,
        ];

        $product = Product::create($productData);
        $this->existingProducts[$productName] = $product->id;

        return $product->id;
    }

    /**
     * Get HPP price for product
     */
    private function getHppPrice($productId)
    {
        $productPrice = ProductPrice::where('product_id', $productId)
            ->where('company_id', $this->company->id)
            ->where('branch_id', $this->branch->id)
            ->first();

        return $productPrice ? $productPrice->hpp_average : 0;
    }

    /**
     * Parse CSV file efficiently
     */
    private function parseCSV($filePath)
    {
        $handle = fopen($filePath, 'r');
        if (! $handle) {
            throw new Exception("Cannot open CSV file: {$filePath}");
        }

        $header = fgetcsv($handle);
        $data = [];

        while (($row = fgetcsv($handle)) !== false) {
            if (count($row) === count($header)) {
                $data[] = array_combine($header, $row);
            }
        }

        fclose($handle);

        return $data;
    }

    /**
     * Convert date format from various formats to yyyy-mm-dd
     */
    private function convertDateFormat($dateString)
    {
        // Handle different date formats
        $formats = ['Y-m-d', 'd-m-Y', 'd/m/Y', 'm/d/Y'];

        foreach ($formats as $format) {
            $date = \DateTime::createFromFormat($format, $dateString);
            if ($date) {
                return $date->format('Y-m-d');
            }
        }

        // Fallback to today if parsing fails
        return date('Y-m-d');
    }
}
