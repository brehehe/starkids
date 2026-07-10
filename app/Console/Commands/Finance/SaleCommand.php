<?php

namespace App\Console\Commands\Finance;

use App\Models\Account\Account;
use App\Models\Account\AccountTransaction;
use App\Models\Company\Company;
use App\Models\Finance\Finance;
use App\Models\Finance\FinanceItem;
use App\Models\Finance\FinanceOther;
use App\Models\Finance\FinancePayment;
use App\Models\Finance\FinanceRecipe;
use App\Models\Journal\Journal;
use App\Models\Journal\JournalItem;
use App\Models\PaymentMethod\PaymentMethod;
use App\Models\Product\ProductPrice;
use App\Models\Transaction\Transaction;
use App\Services\Finance\FinanceAccountTransactionService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleCommand extends Command
{
    // Account Codes Constants
    private const ACCOUNT_CODES = [
        'CASH' => '1-10001',
        'RECEIVABLE' => '1-10100',
        'REVENUE' => '4-40000',
        'VAT_OUTPUT' => '2-20500',
        'INVENTORY' => '1-10200',
        'COST_OF_GOODS_SOLD' => '5-50000',
        'OTHER_INCOME' => '7-70099',
        'OTHER_EXPENSE' => '8-80999',
        'INTEREST_EXPENSE' => '8-80000',
    ];

    // Finance Type Constants
    private const FINANCE_TYPES = [
        'FIRST_SERVICE' => 'first-service-price',
        'SECOND_SERVICE' => 'second-service-price',
        'PAYMENT_CHANGE' => 'payment-change',
        'ADMIN_FEE' => 'admin-fee',
        'ROUNDING' => 'rounding',
    ];

    public $cash;

    public $receivable;

    public $pendapatan;

    public $ppn_keluaran;

    public $persediaan;

    public $bebanpokokpendapatan;

    public $pendapatanlainlain;

    public $bebanlainlain;

    public $bebanBunga;

    protected $signature = 'app:sale-command {--reset : Reset sales before processing}';

    protected $description = 'Process completed sales transactions into finance records with journal entries';

    public function handle()
    {
        if ($this->option('reset')) {
            $this->resetSale();
            $this->info('Sales reset completed.');

            return;
        }
        $this->_processSale();
    }

    private function getAccountCompany($company)
    {
        $this->cash = Account::select('id', 'name')
            ->where('code', '1-10001')
            ->where('company_id', $company->id)
            ->first();
        $this->receivable = Account::select('id', 'name')
            ->where('code', '1-10100')
            ->where('company_id', $company->id)
            ->first();
        $this->pendapatan = Account::select('id', 'name')
            ->where('code', '4-40000')
            ->where('company_id', $company->id)
            ->first();
        $this->ppn_keluaran = Account::select('id', 'name')
            ->where('code', '2-20500')
            ->where('company_id', $company->id)
            ->first();
        $this->persediaan = Account::select('id', 'name')
            ->where('code', '1-10200')
            ->where('company_id', $company->id)
            ->first();
        $this->bebanpokokpendapatan = Account::select('id', 'name')
            ->where('code', '5-50000')
            ->where('company_id', $company->id)
            ->first();
        $this->pendapatanlainlain = Account::select('id', 'name')
            ->where('code', '7-70099')
            ->where('company_id', $company->id)
            ->first();
        $this->bebanlainlain = Account::select('id', 'name')
            ->where('code', '8-80999')
            ->where('company_id', $company->id)
            ->first();
        $this->bebanBunga = Account::select('id', 'name')
            ->where('code', '8-80000')
            ->where('company_id', $company->id)
            ->first();
    }

    private function resetSale(): void
    {
        $companies = Company::select('id', 'name')->get();

        foreach ($companies as $company) {
            $transactions = Transaction::where('company_id', $company->id)
                ->where('status', 'completed')
                // ->where('is_process_finance', true)
                ->get();

            foreach ($transactions as $transaction) {
                $this->info("Resetting sale for company: {$company->name} - Transaction Code: {$transaction->code}");
                $finances = Finance::where('transaction_id', $transaction->id)
                    ->where('company_id', $company->id)
                    ->get();

                foreach ($finances as $finance) {
                    Journal::where('finance_id', $finance->id)
                        ->where('company_id', $company->id)
                        ->delete();
                    JournalItem::where('finance_id', $finance->id)
                        ->where('company_id', $company->id)
                        ->delete();

                    FinancePayment::where('finance_id', $finance->id)
                        ->where('company_id', $company->id)
                        ->delete();

                    FinanceItem::where('finance_id', $finance->id)
                        ->where('company_id', $company->id)
                        ->delete();

                    FinanceOther::where('finance_id', $finance->id)
                        ->where('company_id', $company->id)
                        ->delete();

                    FinanceRecipe::where('finance_id', $finance->id)
                        ->where('company_id', $company->id)
                        ->delete();

                    AccountTransaction::where('finance_id', $finance->id)
                        ->where('company_id', $company->id)
                        ->delete();

                    $finance->delete();
                    $this->info("Deleting finance record: {$finance->code} for company: {$company->name}");
                    $finance->delete();
                }

                $transaction->is_process_finance = false;
                $transaction->save();
            }
        }
    }

    private function _processSale()
    {
        $this->info('🔄 Processing sales...');
        $companies = Company::select('id', 'name')->get();

        foreach ($companies as $company) {
            $this->info("Processing sale for company: {$company->name}");

            $this->getAccountCompany($company);

            $sales = Transaction::with([
                'transactionPayments.paymentMethod',
                'transactionRecipes.product',
                'transactionDetails.product',
            ])
                ->where('company_id', $company->id)
                ->where('status', 'completed')
                ->where('is_process_finance', false)
                ->get();

            if ($sales->isEmpty()) {
                $this->info("No sales found for company: {$company->name}");

                continue;
            }

            // Pre-fetch Product Prices for all products involved
            $productIds = collect([]);
            foreach ($sales as $sale) {
                if ($sale->transactionRecipes) {
                    $productIds = $productIds->merge($sale->transactionRecipes->pluck('product_id'));
                }
                if ($sale->transactionDetails) {
                    $productIds = $productIds->merge($sale->transactionDetails->pluck('product_id'));
                }
            }
            $productIds = $productIds->unique()->filter();

            $productPrices = ProductPrice::whereIn('product_id', $productIds)
                ->where('company_id', $company->id)
                ->get()
                ->keyBy('product_id');

            DB::transaction(function () use ($sales, $company, $productPrices) {
                foreach ($sales as $sale) {
                    $this->info("Processing sale: {$sale->code} for company: {$company->name}");

                    $paymentChange = intval(Str::replace('.', '', number_format($sale->payment_change, 0, ',', '.')));

                    // Accumulator for Journal Entries
                    // Format: [account_id => ['amount' => X, 'type' => 'debit'/'credit', 'description_suffix' => '...']]
                    $journalEntries = [];

                    // Using grand_total_price based on earlier fix
                    $finance = Finance::create([
                        'transaction_id' => $sale->id,
                        'type' => 'sale',
                        'description' => 'Sale transaction for '.$sale->code,
                        'date' => $sale->created_at->format('Y-m-d'),
                        'sub_total' => $sale->sub_total_price,
                        'single_payment_admin_fee' => $sale->single_payment_admin_fee,
                        'first_service_price' => $sale->first_service_price,
                        'second_service_price' => $sale->second_service_price,
                        'embalage' => $sale->embalage,
                        'rounding' => $sale->rounding,
                        'grand_total' => $sale->grand_total_price,
                        'payment_change' => $paymentChange,
                        'status' => 'draft',
                        'company_id' => $company->id,
                    ]);

                    $journal = Journal::create(
                        [
                            'finance_id' => $finance->id,
                            'company_id' => $company->id,
                            'date' => Carbon::now(),
                        ]
                    );

                    // Use pre-loaded relationship
                    $transactionPayments = $sale->transactionPayments;

                    foreach ($transactionPayments as $payment) {
                        $paymentMethod = $payment->paymentMethod;

                        if (! $paymentMethod) {
                            $this->warn("Payment method not found for payment ID: {$payment->id}. Defaulting to Tunai.");

                            $paymentMethod = PaymentMethod::where('company_id', $company->id)
                                ->where(function ($q) {
                                    $q->where('name', 'ilike', '%Tunai%')
                                        ->orWhere('name', 'ilike', '%Cash%');
                                })
                                ->first();

                            if (! $paymentMethod || ! $paymentMethod->account_id) {
                                $this->error("Default 'Tunai' payment method not found or has no account. Skipping.");

                                continue;
                            }
                        }

                        $financePayment = FinancePayment::create([
                            'finance_id' => $finance->id,
                            'transaction_payment_id' => $payment->id,
                            'amount' => $payment->payment_amount,
                            'account_payment_id' => $paymentMethod->account_id,
                            'account_debt_id' => $this->receivable->id,
                            'company_id' => $company->id,
                        ]);

                        // Accumulate Payment Journal
                        // Debit Payment Account
                        if (! isset($journalEntries[$paymentMethod->account_id])) {
                            $journalEntries[$paymentMethod->account_id] = ['amount' => 0, 'type' => 'debit'];
                        }
                        $journalEntries[$paymentMethod->account_id]['amount'] += $payment->payment_amount;
                    }

                    if ($finance->first_service_price > 0) {
                        FinanceOther::create([
                            'finance_id' => $finance->id,
                            'name' => 'First Service Price',
                            'account_id' => $this->pendapatan->id,
                            'description' => 'First Service Price for Sale Code: '.$sale->code,
                            'amount' => $sale->first_service_price,
                            'type' => 'credit',
                            'type_finance' => 'first-service-price',
                            'company_id' => $company->id,
                        ]);

                        // Accumulate Revenue
                        if (! isset($journalEntries[$this->pendapatan->id])) {
                            $journalEntries[$this->pendapatan->id] = ['amount' => 0, 'type' => 'credit'];
                        }
                        $journalEntries[$this->pendapatan->id]['amount'] += $sale->first_service_price;
                    }

                    if ($finance->second_service_price > 0) {
                        FinanceOther::create([
                            'finance_id' => $finance->id,
                            'name' => 'Second Service Price',
                            'account_id' => $this->pendapatan->id,
                            'description' => 'Second Service Price for Sale Code: '.$sale->code,
                            'amount' => $sale->second_service_price,
                            'type' => 'credit',
                            'type_finance' => 'second-service-price',
                            'company_id' => $company->id,
                        ]);

                        // Accumulate Revenue
                        if (! isset($journalEntries[$this->pendapatan->id])) {
                            $journalEntries[$this->pendapatan->id] = ['amount' => 0, 'type' => 'credit'];
                        }
                        $journalEntries[$this->pendapatan->id]['amount'] += $sale->second_service_price;
                    }

                    if ($finance->payment_change > 0) {
                        FinanceOther::create([
                            'finance_id' => $finance->id,
                            'name' => 'Payment Change',
                            'account_id' => $this->cash->id,
                            'description' => 'Payment Change for Sale Code: '.$sale->code,
                            'amount' => $paymentChange,
                            'type' => 'credit',
                            'type_finance' => 'payment-change',
                            'company_id' => $company->id,
                        ]);

                        // Accumulate Payment Change (Credit Cash)
                        if (! isset($journalEntries[$this->cash->id])) {
                            $journalEntries[$this->cash->id] = ['amount' => 0, 'type' => 'credit'];
                        }
                        $journalEntries[$this->cash->id]['amount'] += $paymentChange;
                    }

                    if ($finance->single_payment_admin_fee > 0) {
                        FinanceOther::create([
                            'finance_id' => $finance->id,
                            'name' => 'Admin Fee',
                            'account_id' => $this->cash->id,
                            'description' => 'Admin Fee for Sale Code: '.$sale->code,
                            'amount' => $sale->single_payment_admin_fee,
                            'type' => 'credit',
                            'type_finance' => 'admin-fee',
                            'company_id' => $company->id,
                        ]);

                        // Accumulate Admin Fee (Credit Cash?? Or Revenue? Description says "Pendapatan - ... Biaya Admin")
                        // Providing code used $this->cash->id and type 'credit'.
                        if (! isset($journalEntries[$this->cash->id])) {
                            $journalEntries[$this->cash->id] = ['amount' => 0, 'type' => 'credit'];
                        }
                        $journalEntries[$this->cash->id]['amount'] += $sale->single_payment_admin_fee;
                    }

                    $rounding = abs($finance->rounding);
                    if ($rounding > 0) {
                        if ($sale->rounding > 0) {
                            FinanceOther::create([
                                'finance_id' => $finance->id,
                                'name' => 'Rounding',
                                'account_id' => $this->pendapatan->id,
                                'description' => 'Rounding for Sale Code: '.$sale->code,
                                'amount' => $rounding,
                                'type' => 'credit',
                                'type_finance' => 'rounding',
                                'company_id' => $company->id,
                            ]);

                            // Accumulate Rounding Credit (Revenue)
                            if (! isset($journalEntries[$this->pendapatan->id])) {
                                $journalEntries[$this->pendapatan->id] = ['amount' => 0, 'type' => 'credit'];
                            }
                            $journalEntries[$this->pendapatan->id]['amount'] += $rounding;

                        } elseif ($sale->rounding < 0) {
                            FinanceOther::create([
                                'finance_id' => $finance->id,
                                'name' => 'Rounding',
                                'account_id' => $this->bebanlainlain->id,
                                'description' => 'Rounding for Sale Code: '.$sale->code,
                                'amount' => $rounding,
                                'type' => 'debit',
                                'type_finance' => 'rounding',
                                'company_id' => $company->id,
                            ]);

                            // Accumulate Rounding Debit (Expense)
                            if (! isset($journalEntries[$this->bebanlainlain->id])) {
                                $journalEntries[$this->bebanlainlain->id] = ['amount' => 0, 'type' => 'debit'];
                            }
                            $journalEntries[$this->bebanlainlain->id]['amount'] += $rounding;
                        }
                    }

                    // Use eager loaded transactionRecipes
                    $transactionRecips = $sale->transactionRecipes;

                    foreach ($transactionRecips as $recipe) {
                        $dppPPNRecipe = $this->getDppPPN($recipe->sub_total_price, true, 11);

                        // Use pre-fetched product price
                        $productPrice = $productPrices[$recipe->product_id] ?? null;

                        $recipe->price_hpp = $recipe->price_hpp ?? $productPrice?->price_hpp ?? 0;
                        $recipe->sub_total_price_hpp = $recipe->quantity * $recipe->price_hpp;
                        $financeRecipe = FinanceRecipe::create([
                            'finance_id' => $finance->id,
                            'transaction_recipe_id' => $recipe->id,
                            'medicine_type_id' => $recipe->medicine_type_id,
                            'price_service_one' => $recipe->price_service_one,
                            'numero_recipe' => $recipe->numero_recipe,
                            'product_id' => $recipe->product_id,
                            'product_name' => $recipe?->product?->name ?? '-',
                            'quantity' => $recipe->quantity,
                            'price' => $recipe->price,
                            'price_hpp' => $recipe->price_hpp,
                            'sub_total_price' => $recipe->sub_total_price,
                            'sub_total_price_hpp' => $recipe->sub_total_price_hpp,
                            'sub_total_price_ppn' => $dppPPNRecipe['ppn'],
                            'sub_total_price_dpp' => $dppPPNRecipe['dpp'],
                            'company_id' => $company->id,
                        ]);

                        if ($financeRecipe->sub_total_price_dpp > 0) {
                            if (! isset($journalEntries[$this->pendapatan->id])) {
                                $journalEntries[$this->pendapatan->id] = ['amount' => 0, 'type' => 'credit'];
                            }
                            $journalEntries[$this->pendapatan->id]['amount'] += $financeRecipe->sub_total_price_dpp;
                        }

                        if ($financeRecipe->sub_total_price_ppn > 0) {
                            if (! isset($journalEntries[$this->ppn_keluaran->id])) {
                                $journalEntries[$this->ppn_keluaran->id] = ['amount' => 0, 'type' => 'credit'];
                            }
                            $journalEntries[$this->ppn_keluaran->id]['amount'] += $financeRecipe->sub_total_price_ppn;
                        }

                        if ($financeRecipe->sub_total_price_hpp > 0) {
                            // Credit Persediaan
                            if (! isset($journalEntries[$this->persediaan->id])) {
                                $journalEntries[$this->persediaan->id] = ['amount' => 0, 'type' => 'credit'];
                            }
                            $journalEntries[$this->persediaan->id]['amount'] += $financeRecipe->sub_total_price_hpp;

                            // Debit Beban Pokok
                            if (! isset($journalEntries[$this->bebanpokokpendapatan->id])) {
                                $journalEntries[$this->bebanpokokpendapatan->id] = ['amount' => 0, 'type' => 'debit'];
                            }
                            $journalEntries[$this->bebanpokokpendapatan->id]['amount'] += $financeRecipe->sub_total_price_hpp;
                        }

                        $this->getTransactionDetails($company, $journal, $finance, $sale, $recipe, $financeRecipe, $productPrices, $journalEntries);
                    }

                    $this->getTransactionDetailMedicineAction($company, $journal, $finance, $sale, $productPrices, $journalEntries);
                    $this->getTransactionDetailOther($company, $journal, $finance, $sale, $productPrices, $journalEntries);

                    // Process Accumulated Journal Entries
                    foreach ($journalEntries as $accountId => $entry) {
                        if ($entry['amount'] > 0) {
                            $journalItem = JournalItem::create([
                                'finance_id' => $finance->id,
                                'company_id' => $company->id,
                                'journal_id' => $journal->id,
                                'account_id' => $accountId,
                                'type' => $entry['type'],
                            ]);

                            $description = 'Accumulated '.ucfirst($entry['type']).' for Sale Code: '.$sale->code;

                            if ($entry['type'] === 'credit') {
                                app(FinanceAccountTransactionService::class)->AccountTransactionCredit(
                                    $finance,
                                    null,
                                    null,
                                    $company->id,
                                    $accountId,
                                    $description,
                                    $entry['amount'],
                                    Carbon::now(),
                                    $journal,
                                    $journalItem
                                );
                            } else {
                                app(FinanceAccountTransactionService::class)->AccountTransactionDebit(
                                    $finance,
                                    null,
                                    null,
                                    $company->id,
                                    $accountId,
                                    $description,
                                    $entry['amount'],
                                    Carbon::now(),
                                    $journal,
                                    $journalItem
                                );
                            }
                        }
                    }

                    $sale->is_process_finance = true;
                    $sale->save();
                }
            });
        }
        $this->info('✅ All sales have been processed successfully.');
    }

    private function getTransactionDetails($company, $journal, $finance, $sale, $recipe, $financeRecipe, $productPrices, &$journalEntries)
    {
        // Use filtered collection instead of DB query
        $transactionDetails = $sale->transactionDetails
            ->where('transaction_recipe_id', $recipe->id);

        foreach ($transactionDetails as $detail) {
            $this->info('Mendapatkan Detail : '.$detail->id);
            $detail->sub_total_price = intval(Str::replace('.', '', number_format($detail->sub_total_price, 0, ',', '.')));

            // Use pre-fetched product price
            $productPrice = $productPrices[$detail->product_id] ?? null;

            $detail->price_hpp = $detail->price_hpp ?? $productPrice?->price_hpp ?? 0;
            $detail->sub_total_price_hpp = $detail->quantity * $detail->price_hpp;
            $dppPPNRecipe = $this->getDppPPN($detail->sub_total_price, true, 11);
            $this->info('Total : '.$detail->sub_total_price);
            $this->info('dpp : '.$dppPPNRecipe['dpp']);
            $this->info('ppn : '.$dppPPNRecipe['ppn']);

            $financeItem = FinanceItem::create([
                'finance_id' => $finance->id,
                'finance_recipe_id' => $financeRecipe->id,
                'transaction_detail_id' => $detail->id,
                'product_id' => $detail->product_id,
                'product_name' => $detail?->product?->name ?? '-',
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'price_hpp' => $detail->price_hpp,
                'sub_total' => $detail->sub_total_price,
                'sub_total_hpp' => $detail->sub_total_price_hpp,
                'sub_total_ppn' => $dppPPNRecipe['ppn'],
                'sub_total_dpp' => $dppPPNRecipe['dpp'],
                'company_id' => $company->id,
            ]);

            if ($financeItem->sub_total_dpp > 0) {
                if (! isset($journalEntries[$this->pendapatan->id])) {
                    $journalEntries[$this->pendapatan->id] = ['amount' => 0, 'type' => 'credit'];
                }
                $journalEntries[$this->pendapatan->id]['amount'] += $financeItem->sub_total_dpp;
            }

            if ($financeItem->sub_total_ppn > 0) {
                if (! isset($journalEntries[$this->ppn_keluaran->id])) {
                    $journalEntries[$this->ppn_keluaran->id] = ['amount' => 0, 'type' => 'credit'];
                }
                $journalEntries[$this->ppn_keluaran->id]['amount'] += $financeItem->sub_total_ppn;
            }

            if ($financeItem->sub_total_price_hpp > 0) {
                // Credit Persediaan
                if (! isset($journalEntries[$this->persediaan->id])) {
                    $journalEntries[$this->persediaan->id] = ['amount' => 0, 'type' => 'credit'];
                }
                $journalEntries[$this->persediaan->id]['amount'] += $financeItem->sub_total_price_hpp;

                // Debit Beban Pokok
                if (! isset($journalEntries[$this->bebanpokokpendapatan->id])) {
                    $journalEntries[$this->bebanpokokpendapatan->id] = ['amount' => 0, 'type' => 'debit'];
                }
                $journalEntries[$this->bebanpokokpendapatan->id]['amount'] += $financeItem->sub_total_price_hpp;
            }
        }
    }

    private function getTransactionDetailMedicineAction($company, $journal, $finance, $sale, $productPrices, &$journalEntries)
    {
        // Use filtered collection instead of DB query
        $transactionDetails = $sale->transactionDetails
            ->whereIn('type_transaction', ['medicine', 'action']);

        foreach ($transactionDetails as $detail) {
            $this->info('Mendapatkan Detail Medicine & Action '.$detail->id);
            $dppPPNRecipe = $this->getDppPPN($detail->sub_total_price, true, 11);

            // Use pre-fetched product price
            $productPrice = $productPrices[$detail->product_id] ?? null;

            $detail->price_hpp = $detail->price_hpp ?? $productPrice?->price_hpp ?? 0;
            $detail->sub_total_price_hpp = $detail->quantity * $detail->price_hpp;

            $financeItem = FinanceItem::create([
                'finance_id' => $finance->id,
                'transaction_detail_id' => $detail->id,
                'product_id' => $detail->product_id,
                'product_name' => $detail?->product?->name ?? '-',
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'price_hpp' => $detail->price_hpp,
                'sub_total' => $detail->sub_total_price,
                'sub_total_hpp' => $detail->sub_total_price_hpp,
                'sub_total_ppn' => $dppPPNRecipe['ppn'],
                'sub_total_dpp' => $dppPPNRecipe['dpp'],
                'company_id' => $company->id,
            ]);

            // Accumulate journal entries instead of creating individual items
            if ($financeItem->sub_total_dpp > 0) {
                if (! isset($journalEntries[$this->pendapatan->id])) {
                    $journalEntries[$this->pendapatan->id] = ['amount' => 0, 'type' => 'credit'];
                }
                $journalEntries[$this->pendapatan->id]['amount'] += $financeItem->sub_total_dpp;
            }

            if ($financeItem->sub_total_ppn > 0) {
                if (! isset($journalEntries[$this->ppn_keluaran->id])) {
                    $journalEntries[$this->ppn_keluaran->id] = ['amount' => 0, 'type' => 'credit'];
                }
                $journalEntries[$this->ppn_keluaran->id]['amount'] += $financeItem->sub_total_ppn;
            }

            if ($financeItem->sub_total_hpp > 0) {
                // Credit Persediaan
                if (! isset($journalEntries[$this->persediaan->id])) {
                    $journalEntries[$this->persediaan->id] = ['amount' => 0, 'type' => 'credit'];
                }
                $journalEntries[$this->persediaan->id]['amount'] += $financeItem->sub_total_hpp;

                // Debit Beban Pokok
                if (! isset($journalEntries[$this->bebanpokokpendapatan->id])) {
                    $journalEntries[$this->bebanpokokpendapatan->id] = ['amount' => 0, 'type' => 'debit'];
                }
                $journalEntries[$this->bebanpokokpendapatan->id]['amount'] += $financeItem->sub_total_hpp;
            }
        }
    }

    private function getTransactionDetailOther($company, $journal, $finance, $sale, $productPrices, &$journalEntries)
    {
        // Use filtered collection instead of DB query
        $transactionDetails = $sale->transactionDetails
            ->whereIn('type_transaction', ['other']);

        foreach ($transactionDetails as $detail) {
            $this->info('Mendapatkan Detail Other '.$detail->id);
            $dppPPNRecipe = $this->getDppPPN($detail->sub_total_price, true, 11);

            $financeItem = FinanceItem::create([
                'finance_id' => $finance->id,
                'transaction_detail_id' => $detail->id,
                'product_id' => $detail->product_id,
                'product_name' => $detail?->product?->name ?? '-',
                'quantity' => $detail->quantity,
                'price' => $detail->price,
                'price_hpp' => $detail->price_hpp,
                'sub_total' => $detail->sub_total_price,
                'sub_total_hpp' => $detail->sub_total_price_hpp,
                'sub_total_ppn' => $dppPPNRecipe['ppn'],
                'sub_total_dpp' => $dppPPNRecipe['dpp'],
                'company_id' => $company->id,
            ]);

            if ($financeItem->sub_total_price > 0) {
                if (! isset($journalEntries[$this->pendapatan->id])) {
                    $journalEntries[$this->pendapatan->id] = ['amount' => 0, 'type' => 'credit'];
                }
                $journalEntries[$this->pendapatan->id]['amount'] += $financeItem->sub_total_price;
            }
        }
    }

    private function getDppPPN($amount, $isTaxIncluded = true, $rate = 11)
    {
        if ($isTaxIncluded) {
            $dpp = $amount / (1 + $rate / 100);
            $ppn = $amount - $dpp;
        } else {
            $dpp = $amount;
            $ppn = $amount * ($rate / 100);
        }

        return [
            'dpp' => intval(Str::replace('.', '', number_format(round($dpp, 2), 0, ',', '.'))),
            'ppn' => intval(Str::replace('.', '', number_format(round($ppn, 2), 0, ',', '.'))),
        ];
    }
}
