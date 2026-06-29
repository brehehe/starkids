<?php

/**
 * Contoh penggunaan fitur Deposit Discount
 *
 * File ini menunjukkan cara menggunakan fitur diskon otomatis dari deposit
 * di sistem {{config('app.name')}}.
 */

// Contoh 1: Membuat transaksi dengan deposit
use App\Models\Deposit\Deposit;
use App\Models\Transaction\Transaction;

class DepositDiscountExample
{
    public function createTransactionWithDeposit()
    {
        // 1. Buat atau ambil deposit yang sudah ada
        $deposit = Deposit::create([
            'code' => Deposit::generateCode(),
            'patient_id' => $patientId,
            'user_type_id' => $userTypeId,
            'sub_total_price' => 500000, // Rp 500.000
            'grand_total_price' => 500000, // Rp 500.000
            'status' => 'success',
            'company_id' => auth()->user()->company_id,
            'branch_id' => $branchId,
        ]);

        // 2. Buat transaksi dengan deposit_id
        $transaction = Transaction::create([
            'code' => Transaction::generateCode(),
            'deposit_id' => $deposit->id, // PENTING: Set deposit_id
            'patient_id' => $patientId,
            'type' => 'resep',
            'status' => 'draft',
            'sub_total_price' => 750000, // Rp 750.000
            'grand_total_price' => 250000, // Akan menjadi Rp 250.000 setelah diskon deposit
            'company_id' => auth()->user()->company_id,
            'branch_id' => $branchId,
        ]);

        return $transaction;
    }

    public function demonstrateAutoDiscount()
    {
        // Ketika component AdminSalePosRecipeIndex dimount:

        // 1. checkDepositDiscount() akan dipanggil
        // 2. Sistem mendeteksi $transaction->deposit_id
        // 3. Mengambil $deposit->grand_total_price = 500000
        // 4. Set $has_deposit = true
        // 5. Set $deposit_discount_amount = 500000
        // 6. Set $discount = "500.000" (format rupiah)
        // 7. Set $discount_type = "rupiah"
        // 8. Set $promotion_simplified_id = null

        // Hasil di UI:
        // - Field promosi: DISABLED dengan pesan "Nonaktif karena deposit"
        // - Field diskon: READONLY dengan nilai "500.000"
        // - Tipe diskon: Terkunci di "Rp" (tidak bisa diubah ke %)
        // - Warna orange untuk menandakan mode deposit aktif
    }

    public function validateUserActions()
    {
        // Jika user mencoba mengubah diskon manual:
        // updatedDiscount() akan mengembalikan ke nilai deposit

        // Jika user mencoba memilih promosi:
        // updatedPromotionSimplifiedId() akan mengosongkan pilihan
        // dan menampilkan peringatan

        // Jika user mencoba mengubah tipe diskon:
        // updatedDiscountType() akan mempertahankan "rupiah"
    }

    public function exampleTransactionFlow()
    {
        // Flow lengkap transaksi dengan deposit:

        // 1. PREPARATION
        $deposit = $this->createDeposit(500000); // Rp 500k deposit
        $transaction = $this->createTransaction($deposit->id);

        // 2. ADD PRODUCTS (total misal Rp 750k)
        $this->addMedicine($transaction, 'Paracetamol', 250000);
        $this->addMedicine($transaction, 'Amoxicillin', 300000);
        $this->addService($transaction, 'Konsultasi', 200000);
        // Total: Rp 750.000

        // 3. AUTOMATIC DISCOUNT APPLICATION
        // Sistem otomatis apply diskon Rp 500k dari deposit
        // Grand total menjadi: Rp 750.000 - Rp 500.000 = Rp 250.000

        // 4. PAYMENT
        $this->addPayment($transaction, 'Cash', 250000);

        // 5. COMPLETE
        $transaction->update(['status' => 'completed']);

        return $transaction;
    }

    private function createDeposit($amount)
    {
        return Deposit::create([
            'code' => Deposit::generateCode(),
            'patient_id' => 1,
            'user_type_id' => 1,
            'sub_total_price' => $amount,
            'grand_total_price' => $amount,
            'status' => 'success',
            'company_id' => 1,
            'branch_id' => 1,
        ]);
    }

    private function createTransaction($depositId)
    {
        return Transaction::create([
            'code' => Transaction::generateCode(),
            'deposit_id' => $depositId,
            'patient_id' => 1,
            'type' => 'resep',
            'status' => 'draft',
            'company_id' => 1,
            'branch_id' => 1,
        ]);
    }
}

/**
 * Contoh testing manual:
 */
class ManualTestingGuide
{
    public function testDepositDiscount()
    {
        echo "=== TESTING DEPOSIT DISCOUNT FEATURE ===\n";

        // 1. Buat deposit dengan nilai tertentu
        echo "1. Creating deposit with Rp 300.000...\n";

        // 2. Buat transaksi dengan deposit_id
        echo "2. Creating transaction with deposit_id...\n";

        // 3. Akses halaman POS resep
        echo "3. Access POS recipe page...\n";

        // 4. Verifikasi UI
        echo "4. Verify UI elements:\n";
        echo "   - Promotion field should be DISABLED\n";
        echo "   - Discount field should be READONLY with '300.000'\n";
        echo "   - Discount type locked to 'Rp'\n";
        echo "   - Orange styling for deposit mode\n";

        // 5. Test user interactions
        echo "5. Test user interactions:\n";
        echo "   - Try to change discount -> should revert\n";
        echo "   - Try to select promotion -> should be blocked\n";
        echo "   - Try to change discount type -> should stay 'Rp'\n";

        echo "=== TEST COMPLETED ===\n";
    }
}
