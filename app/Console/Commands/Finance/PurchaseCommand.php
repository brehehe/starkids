<?php

namespace App\Console\Commands\Finance;

use App\Models\Account\Account;
use App\Models\Company\Company;
use App\Models\Finance\Finance;
use App\Models\Finance\FinanceItem;
use App\Models\Finance\FinancePayment;
use App\Models\Journal\Journal;
use App\Models\Journal\JournalItem;
use App\Models\PurchaseOrder\PurchaseOrder;
use App\Models\PurchaseOrder\PurchaseOrderItem;
use App\Services\Finance\FinanceAccountTransactionService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PurchaseCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:purchase-command {--reset : Reset purchase orders before processing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process completed purchase orders into finance records';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->option('reset')) {
            $this->_resetPurchase();

            return;
        }

        $this->_processPurchase();
    }

    private function _resetPurchase()
    {
        $companies = Company::select('id', 'name')->get();

        foreach ($companies as $company) {
            // Get processed purchase orders
            $purchaseOrders = PurchaseOrder::where('company_id', $company->id)
                // ->where('is_process_finance', true)
                ->get();

            foreach ($purchaseOrders as $purchaseOrder) {
                $this->info("Resetting purchase order: {$purchaseOrder->number} for company: {$company->name}");

                // Find processed finance via purchase order items -> finance items
                $purchaseOrderItems = PurchaseOrderItem::where('purchase_order_id', $purchaseOrder->id)->get();
                $financeIds = FinanceItem::whereIn('purchase_order_item_id', $purchaseOrderItems->pluck('id'))
                    ->where('company_id', $company->id)
                    ->pluck('finance_id')
                    ->unique();

                $finances = Finance::whereIn('id', $financeIds)->get();

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

                    $finance->delete();
                    $this->info("Deleted finance record: {$finance->code}");
                }

                $purchaseOrder->is_process_finance = false;
                $purchaseOrder->save();
            }
        }
        $this->info('Purchase reset successfully.');
    }

    private function _processPurchase()
    {
        $companies = Company::select('id', 'name')->get();

        foreach ($companies as $company) {
            $purchaseOrders = PurchaseOrder::where('company_id', $company->id)
                ->where('is_process_finance', false)
                ->get();

            if ($purchaseOrders->isEmpty()) {
                $this->info("No purchase orders found for company name: {$company->name}");

                continue;
            }

            foreach ($purchaseOrders as $purchaseOrder) {
                $purchaseOrderItems = PurchaseOrderItem::where('purchase_order_id', $purchaseOrder->id)
                    ->where('quantity_accepted', '>', 0)
                    ->where('company_id', $company->id)
                    ->get();

                DB::transaction(function () use ($purchaseOrder, $company, $purchaseOrderItems) {
                    $purchaseOrder->grand_total_real = 0;
                    $purchaseOrder->price_total = 0;
                    $purchaseOrder->price_tax_total = 0;
                    $purchaseOrder->tax_total = 0;

                    foreach ($purchaseOrderItems as $key => $purchaseOrderItem) {
                        $purchaseOrderItem->hna_total = $purchaseOrderItem->quantity * $purchaseOrderItem->hna;
                        $purchaseOrderItem->hna_ppn_total = $purchaseOrderItem->quantity * $purchaseOrderItem->hna_ppn;
                        $purchaseOrderItem->ppn_total = $purchaseOrderItem->quantity * $purchaseOrderItem->ppn;

                        // Calculate total
                        $purchaseOrderItem->total = $purchaseOrderItem->hna_ppn * $purchaseOrderItem->quantity;
                        $purchaseOrderItem->save();

                        $purchaseOrder->grand_total_real += $purchaseOrderItem->total;
                        $purchaseOrder->price_total += $purchaseOrderItem->hna_total;
                        $purchaseOrder->price_tax_total += $purchaseOrderItem->hna_ppn_total;
                        $purchaseOrder->tax_total += $purchaseOrderItem->ppn_total;
                    }

                    // Updated Description as requested: No ID, use Number/Code and Supplier info
                    $description = 'Purchase order processing for company name: '.$company->name.
                        ' - Purchase Order Code: '.$purchaseOrder->number;

                    $finance = Finance::create([
                        'type' => 'purchase',
                        'date' => Carbon::now(),
                        'description' => $description,
                        'sub_total' => $purchaseOrder->price_total,
                        'discount' => $purchaseOrder->discount,
                        'tax' => $purchaseOrder->tax_total,
                        'grand_total' => $purchaseOrder->grand_total_real,
                        'company_id' => $company->id,
                        'status' => 'draft',
                    ]);

                    $accountDebt = Account::where('company_id', $company->id)
                        ->where('code', '2-20100') // Assuming this is the account code for debt
                        ->first();

                    $financePayment = FinancePayment::create([
                        'finance_id' => $finance->id,
                        'company_id' => $company->id,
                        'account_debt_id' => $accountDebt->id, // Use the accountDebt retrieved earlier
                        'amount' => $purchaseOrder->grand_total_real,
                        'date' => Carbon::now(),
                    ]);

                    $journal = Journal::create(
                        [
                            'finance_id' => $finance->id,
                            'company_id' => $company->id,
                            'date' => Carbon::now(),
                            'description' => 'Jurnal for Purchase Order Processing for company name: '.$company->name.' - Purchase Order Code: '.$purchaseOrder->number.' - Finance Code: '.$finance->code,
                        ]
                    );

                    $journalItem = JournalItem::create(
                        [
                            'finance_id' => $finance->id,
                            'company_id' => $company->id,
                            'journal_id' => $journal->id,
                            'finance_payment_id' => $financePayment->id,
                            'account_id' => $accountDebt->id,
                            'type' => 'credit', // Assuming this is a credit transaction
                        ]
                    );

                    app(FinanceAccountTransactionService::class)->AccountTransactionCredit(
                        $finance,
                        null,
                        $financePayment->id,
                        $company->id,
                        $accountDebt->id,
                        'Hutang Usaha - Purchase Order Processing for company name: '.$company->name.' - Purchase Order Code: '.$purchaseOrder->number,
                        $purchaseOrder->grand_total_real,
                        Carbon::now(),
                        $journal,
                        $journalItem
                    );

                    $accountPersediaan = Account::where('company_id', $company->id)
                        ->where('code', '1-10200') // Assuming this is the account code for inventory
                        ->first();

                    $accountPPN = Account::where('company_id', $company->id)
                        ->where('code', '1-10500') // Assuming this is the account code for PPN
                        ->first();

                    $persediaanTotal = 0;
                    $ppnTotal = 0;

                    foreach ($purchaseOrderItems as $key => $value) {
                        FinanceItem::create([
                            'finance_id' => $finance->id,
                            'purchase_order_item_id' => $value->id,
                            'company_id' => $company->id,
                            'product_id' => $value->product_id,
                            'description' => $value->product_name,
                            'quantity' => $value->quantity_accepted,
                            'price' => $value->hna_total,
                            'tax' => $value->ppn_total,
                            'discount' => $value->discount,
                            'sub_total' => $value->total,
                        ]);

                        $persediaanTotal += $value->hna_total;
                        $ppnTotal += $value->ppn_total;
                    }

                    if ($persediaanTotal > 0) {
                        $journalItemPersediaan = JournalItem::create(
                            [
                                'finance_id' => $finance->id,
                                'company_id' => $company->id,
                                'journal_id' => $journal->id,
                                'account_id' => $accountPersediaan->id,
                                'type' => 'debit', // Assuming this is a debit transaction
                            ]
                        );

                        app(FinanceAccountTransactionService::class)->AccountTransactionDebit(
                            $finance,
                            null,
                            null,
                            $company->id,
                            $accountPersediaan->id,
                            'Persediaan Barang - Purchase Order Processing for company name: '.$company->name.' - Purchase Order Code: '.$purchaseOrder->number,
                            $persediaanTotal,
                            Carbon::now(),
                            $journal,
                            $journalItemPersediaan
                        );
                    }

                    if ($ppnTotal > 0) {
                        $journalItemPPN = JournalItem::create(
                            [
                                'finance_id' => $finance->id,
                                'company_id' => $company->id,
                                'journal_id' => $journal->id,
                                'account_id' => $accountPPN->id,
                                'type' => 'debit', // Assuming this is a debit transaction
                            ]
                        );

                        app(FinanceAccountTransactionService::class)->AccountTransactionDebit(
                            $finance,
                            null,
                            null,
                            $company->id,
                            $accountPPN->id,
                            'PPN Masukan - Purchase Order Processing for company name: '.$company->name.' - Purchase Order Code: '.$purchaseOrder->number,
                            $ppnTotal,
                            Carbon::now(),
                            $journal,
                            $journalItemPPN
                        );
                    }

                    $purchaseOrder->is_process_finance = true;
                    $purchaseOrder->save();

                    $this->info("Purchase Order: {$purchaseOrder->number} processed successfully for company: {$company->name}");
                });
            }
        }
    }
}
