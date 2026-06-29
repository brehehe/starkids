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
use App\Models\Unit\Unit;
use App\Models\User;
use App\Models\User\UserType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Disable foreign key constraints (PostgreSQL)

        // Clear existing data
        DB::statement('TRUNCATE TABLE transactions CASCADE');
        DB::statement('TRUNCATE TABLE transaction_details CASCADE');
        DB::statement('TRUNCATE TABLE transaction_payments CASCADE');
        DB::statement('TRUNCATE TABLE transaction_products CASCADE');

        // Cache data yang sering dipakai
        $company = Company::first();
        $branch = Branch::where('company_id', $company->id)->first();
        $adminUser = User::where('company_id', $company->id)->first();

        // Cache payment methods
        $paymentMethods = PaymentMethod::where('company_id', $company->id)
            ->whereIn('name', ['Tunai', 'Kartu Debit'])
            ->pluck('id', 'name')
            ->toArray();

        // Cache product type dan unit
        $productType = ProductType::where('name', 'Jasa')->first();
        $productUnit = Unit::where('name', 'Pcs')->first();

        // Cache existing products
        $existingProducts = Product::where('company_id', $company->id)
            ->pluck('id', 'name')
            ->toArray();

        // Baca dan parse CSV files
        $transactionCsvPath = __DIR__.'/csvs/transaction.csv';
        $transactionDetailCsvPath = __DIR__.'/csvs/transaction_detail.csv';

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

        // Prepare batch data arrays
        $transactionsBatch = [];
        $detailsBatch = [];
        $paymentsBatch = [];
        $productsBatch = [];
        $usersBatch = [];
        $newProductsBatch = [];
        $productsPrices = [];

        $batchSize = 100;
        $currentOrder = Transaction::max('order') ?? 0;

        // Cache untuk mencegah duplikasi user
        $processedUsers = [];

        foreach ($transactionData as $index => $row) {
            // Skip jika sudah ada
            if (Transaction::where('code', $row['code'])->exists()) {
                continue;
            }

            // Process user dengan caching
            $userId = $this->processUser($row, $company, $processedUsers, $usersBatch);

            // Calculate totals
            $totalProductPrice = 0;
            if (isset($groupedDetails[$row['code']])) {
                foreach ($groupedDetails[$row['code']] as $detail) {
                    $totalProductPrice += (float) $detail['sub_total'];
                }
            }

            $currentOrder++;

            // Prepare transaction data
            $transactionId = Str::uuid();

            // Convert date format from dd-mm-yyyy to yyyy-mm-dd for PostgreSQL
            $dateFormatted = $this->convertDateFormat($row['date']);

            $transactionsBatch[] = [
                'id' => $transactionId,
                'code' => $row['code'],
                'doctor_id' => null,
                'doctor_name' => null,
                'location_id' => null,
                'location_name' => null,
                'date' => $dateFormatted,
                'patient_id' => $userId,
                'patient_name' => $row['patient_name'],
                'patient_company_role_id' => null,
                'type_customer' => 'new',
                'branch_id' => $branch->id,
                'product_price' => $totalProductPrice,
                'sub_total_price' => $totalProductPrice,
                'discount_id' => null,
                'discount_real' => 0,
                'discount' => 0,
                'grand_total_price' => $totalProductPrice,
                'payment_amount' => $row['cash'] + $row['debit'],
                'payment_change' => ($row['cash'] + $row['debit']) - $totalProductPrice,
                'remaining_bill' => 0,
                'pharmacy_id' => null,
                'pharmacy_name' => null,
                'cashier_id' => $adminUser->id,
                'cashier_name' => $adminUser->name,
                'company_id' => $company->id,
                'created_by' => $adminUser->id,
                'status' => 'completed',
                'type' => 'non-resep',
                'order' => $currentOrder,
                'created_at' => $dateFormatted.' 00:00:00',
                'updated_at' => $dateFormatted.' 00:00:00',
            ];

            // Prepare payment data
            if ($row['cash'] > 0 && isset($paymentMethods['Tunai'])) {
                $paymentsBatch[] = [
                    'id' => Str::uuid(),
                    'transaction_id' => $transactionId,
                    'payment_method_id' => $paymentMethods['Tunai'],
                    'payment_amount' => $row['cash'],
                    'company_id' => $company->id,
                    'order' => count($paymentsBatch) + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            if ($row['debit'] > 0 && isset($paymentMethods['Kartu Debit'])) {
                $paymentsBatch[] = [
                    'id' => Str::uuid(),
                    'transaction_id' => $transactionId,
                    'payment_method_id' => $paymentMethods['Kartu Debit'],
                    'payment_amount' => $row['debit'],
                    'company_id' => $company->id,
                    'order' => count($paymentsBatch) + 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            // Process transaction details
            if (isset($groupedDetails[$row['code']])) {
                foreach ($groupedDetails[$row['code']] as $detail) {

                    $productId = $this->getOrCreateProduct($detail, $existingProducts, $newProductsBatch, $company, $productType, $productUnit);

                    $hppPrice = $this->getHppPrice($productId, $company->id, $branch->id);
                    $detailId = Str::uuid();
                    $detailsBatch[] = [
                        'id' => $detailId,
                        'transaction_id' => $transactionId,
                        'product_id' => $productId,
                        'name' => $detail['keterangan'],
                        'quantity' => $detail['Qty'],
                        'price' => $detail['price'],
                        'sub_total_price' => $detail['sub_total'],
                        'price_hpp' => $hppPrice,
                        'sub_total_price_hpp' => $hppPrice * $detail['Qty'],
                        'type_transaction' => 'medicine',
                        'company_id' => $company->id,
                        'order' => count($detailsBatch) + 1,
                        'created_at' => $dateFormatted.' 00:00:00',
                        'updated_at' => $dateFormatted.' 00:00:00',
                    ];

                    $productsBatch[] = [
                        'id' => Str::uuid(),
                        'transaction_id' => $transactionId,
                        'transaction_detail_id' => $detailId,
                        'product_id' => $productId,
                        'product_name' => $detail['keterangan'],
                        'quantity' => $detail['Qty'],
                        'price' => $detail['price'],
                        'total' => $detail['sub_total'],
                        'hpp_average' => 0,
                        'hpp_total' => 0,
                        'profit' => $detail['price'] * $detail['Qty'],
                        'margin' => 100,
                        'company_id' => $company->id,
                        'order' => count($productsBatch) + 1,
                        'created_at' => $dateFormatted.' 00:00:00',
                        'updated_at' => $dateFormatted.' 00:00:00',
                    ];

                    $productsPrices = [
                        [
                            'branch_id' => $branch->id,
                            'product_id' => $productId,
                            'company_id' => $company->id,
                        ],
                        [
                            'hpp_average' => 0,
                            'price' => $detail['price'],
                            'is_updated' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ],
                    ];
                }
            }

            // Insert in batches untuk performance
            if (count($transactionsBatch) >= $batchSize) {
                $this->insertBatches($transactionsBatch, $detailsBatch, $paymentsBatch, $productsBatch, $newProductsBatch, $productsPrices);
                $transactionsBatch = $detailsBatch = $paymentsBatch = $productsBatch = $newProductsBatch = $productsPrices = [];
            }
        }

        // Insert remaining data
        if (! empty($transactionsBatch)) {
            $this->insertBatches($transactionsBatch, $detailsBatch, $paymentsBatch, $productsBatch, $newProductsBatch, $productsPrices);
        }

        $this->command->info('Transaction seeding completed successfully!');
    }

    /**
     * Parse CSV file efficiently
     */
    private function parseCSV($filePath)
    {
        $data = array_map('str_getcsv', file($filePath));
        $header = array_shift($data);

        $result = [];
        foreach ($data as $row) {
            $result[] = array_combine($header, $row);
        }

        return $result;
    }

    /**
     * Process user with caching to avoid duplicates
     */
    private function processUser($row, $company, &$processedUsers, &$usersBatch)
    {
        $patientName = $row['patient_name'];

        // Check cache first
        if (isset($processedUsers[$patientName])) {
            return $processedUsers[$patientName];
        }

        // Check if user already exists in database
        $existingUser = User::where('name', $patientName)->first();
        if ($existingUser) {
            $processedUsers[$patientName] = $existingUser->id;

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
            'company_id' => $company->id,
            'type_user' => 'patient',
            'created_at' => now(),
            'updated_at' => now(),
            'user_type_id' => UserType::where('name', 'Umum')->first()->id,
        ];

        // Insert immediately for single user to get ID
        $user = User::create($userData);
        $user->syncRoles('Pasien');
        RoleHelper::assignRoleToUserInCompany($user, 'Pasien', $company->id, null, false, true);

        $processedUsers[$patientName] = $user->id;

        return $user->id;
    }

    /**
     * Get or create product with caching
     */
    private function getOrCreateProduct($detail, &$existingProducts, &$newProductsBatch, $company, $productType, $productUnit)
    {
        $productName = $detail['keterangan'];

        // Check existing products cache
        if (isset($existingProducts[$productName])) {
            return $existingProducts[$productName];
        }

        // Check if product is in new products batch
        foreach ($newProductsBatch as $newProduct) {
            if ($newProduct['name'] === $productName) {
                return $newProduct['id'];
            }
        }

        // Create new product
        $productId = Str::uuid();
        $newProductsBatch[] = [
            'id' => $productId,
            'name' => $productName,
            'company_id' => $company->id,
            'numerator_value' => 0,
            'medicine_dosage' => 0,
            'product_type_id' => $productType ? $productType->id : null,
            'unit_id' => $productUnit ? $productUnit->id : null,
            'is_non_stock' => 1,
            'normal' => 0,
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $existingProducts[$productName] = $productId;

        return $productId;
    }

    /**
     * Insert data in batches for better performance
     */
    private function insertBatches($transactions, $details, $payments, $products, $newProducts, $productsPrices)
    {
        DB::beginTransaction();

        try {
            // Insert new products first
            if (! empty($newProducts)) {
                DB::table('products')->insert($newProducts);
            }

            // Insert transactions
            if (! empty($transactions)) {
                DB::table('transactions')->insert($transactions);
            }

            // Insert transaction details
            if (! empty($details)) {
                DB::table('transaction_details')->insert($details);
            }

            // Insert payments
            if (! empty($payments)) {
                DB::table('transaction_payments')->insert($payments);
            }

            // Insert transaction products
            if (! empty($products)) {
                DB::table('transaction_products')->insert($products);
            }

            // Insert product prices
            if (! empty($productsPrices)) {
                ProductPrice::updateOrCreate($productsPrices[0], $productsPrices[1]);
            }

            DB::commit();

            $this->command->info('Inserted batch: '.count($transactions).' transactions');
        } catch (\Exception $e) {
            DB::rollback();
            $this->command->error('Batch insert failed: '.$e->getMessage());
            throw $e;
        }
    }

    /**
     * Convert date format from dd-mm-yyyy to yyyy-mm-dd
     */
    private function convertDateFormat($dateString)
    {
        // Convert from dd-mm-yyyy to yyyy-mm-dd format for PostgreSQL
        $date = \DateTime::createFromFormat('d-m-Y', $dateString);
        if (! $date) {
            // Try alternative format if first one fails
            $date = \DateTime::createFromFormat('d/m/Y', $dateString);
        }
        if (! $date) {
            // If still fails, try another common format
            $date = \DateTime::createFromFormat('Y-m-d', $dateString);
        }

        return $date ? $date->format('Y-m-d') : date('Y-m-d'); // fallback to today if parsing fails
    }

    /**
     * Get HPP price for a product
     */
    private function getHppPrice($productId, $companyId, $branchId)
    {
        $productPrice = ProductPrice::where('product_id', $productId)
            ->where('company_id', $companyId)
            ->where('branch_id', $branchId)
            ->first();
        if ($productPrice) {
            return $productPrice->hpp_average ?: 0;
        }

        return 0;
    }
}
