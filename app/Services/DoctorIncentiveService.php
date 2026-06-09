<?php

namespace App\Services;

use App\Models\Doctor\DoctorActionIncentive;
use App\Models\Product\Product;
use App\Models\Transaction\Transaction;
use App\Models\Transaction\TransactionAction;
use App\Models\Transaction\TransactionDetail;
use App\Models\User\UserIncentive;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DoctorIncentiveService
{
    /**
     * Hitung dan simpan insentif dokter per-tindakan untuk satu transaksi.
     *
     * Logika prioritas per tindakan:
     *  1. DoctorActionIncentive (override per-user per-tindakan)  →  simpan ke user_incentives
     *  2. Fallback ke products.incentive_doctor / type_incentive_doctor
     *
     * transactions.doctor_id  == users.id  (bukan doctors.id)
     *
     * @param  string|Transaction  $transaction
     * @return int  Jumlah record UserIncentive yang disimpan
     */
    public function calculateForTransaction(string|Transaction $transaction): int
    {
        if (is_string($transaction)) {
            $transaction = Transaction::findOrFail($transaction);
        }

        Log::info('DoctorIncentiveService invoked for transaction', ['transaction_id' => $transaction->id ?? 'unknown']);

        // Transaksi harus punya dokter (user_id)
        $doctorUserId = $transaction->doctor_id;
        if (!$doctorUserId) {
            Log::info('DoctorIncentiveService: no doctor_id for transaction return 0', ['transaction_id' => $transaction->id]);
            return 0;
        }

        // Ambil semua tindakan dari transaction_actions
        $actions = TransactionAction::where('transaction_id', $transaction->id)
            ->whereNotNull('product_id')
            ->get();

        // Ambil semua tindakan/produk dari transaction_details
        $details = TransactionDetail::where('transaction_id', $transaction->id)
            ->whereNotNull('product_id')
            ->get();

        // Gabungkan keduanya
        $allItems = $actions->concat($details);

        Log::info('DoctorIncentiveService items count', [
            'transaction_id' => $transaction->id, 
            'actions_count'  => $actions->count(),
            'details_count'  => $details->count(),
            'total_items'    => $allItems->count()
        ]);

        if ($allItems->isEmpty()) {
            return 0;
        }

        $productIds = $allItems->pluck('product_id')->unique();

        // Pre-load override per-user per-tindakan (avoid N+1)
        $overrides = DoctorActionIncentive::where('user_id', $doctorUserId)
            ->whereIn('product_id', $productIds)
            ->get()
            ->keyBy('product_id');

        Log::info('DoctorIncentiveService overrides', [
            'doctorUserId' => $doctorUserId,
            'productIds'   => $productIds,
            'overrides'    => $overrides->toArray(),
        ]);

        // Pre-load default incentive dari products
        $products = Product::whereIn('id', $productIds)
            ->get(['id', 'type_incentive_doctor', 'incentive_doctor'])
            ->keyBy('id');

        Log::info('DoctorIncentiveService products', [
            'productIds' => $productIds,
            'products'   => $products->toArray(),
        ]);

        $month = $transaction->created_at->format('m');
        $year  = $transaction->created_at->format('Y');
        $saved = 0;

        DB::beginTransaction();
        try {
            foreach ($allItems as $item) {
                $incentiveAmount = $this->resolveIncentive(
                    productId: $item->product_id,
                    price:     (int) $item->price,
                    quantity:  (int) ($item->quantity ?: 1),
                    overrides: $overrides,
                    products:  $products,
                );

                if ($incentiveAmount <= 0) {
                    continue;
                }

                // 1 record per action, upsert via transaction_detail_id = item.id
                UserIncentive::updateOrCreate(
                    [
                        'transaction_id'        => $transaction->id,
                        'transaction_detail_id' => $item->id,
                        'status'                => 'dokter',
                    ],
                    [
                        'user_id'    => $doctorUserId,
                        'amount'     => $incentiveAmount,
                        'description'=> "Insentif Dokter untuk Tindakan/Produk dari Transaksi #{$transaction?->code}",
                        'month'      => $month,
                        'year'       => $year,
                        'company_id' => $transaction->company_id,
                    ]
                );
                $saved++;
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('DoctorIncentiveService error', [
                'transaction_id' => $transaction->id,
                'error'          => $e->getMessage(),
            ]);
            throw $e;
        }

        return $saved;
    }

    /**
     * Resolve nilai insentif dalam Rp untuk satu tindakan.
     * Override (DoctorActionIncentive) diutamakan, fallback ke Product default.
     */
    private function resolveIncentive(
        string $productId,
        int    $price,
        int    $quantity,
        \Illuminate\Support\Collection $overrides,
        \Illuminate\Support\Collection $products,
    ): int {
        // 1. Override per-user per-tindakan
        if ($overrides->has($productId)) {
            $ov = $overrides->get($productId);
            return $this->computeAmount($price, $quantity, $ov->type_incentive, (float) $ov->incentive_value);
        }

        // 2. Default dari product
        if ($products->has($productId)) {
            $prod = $products->get($productId);
            if ($prod->incentive_doctor > 0) {
                return $this->computeAmount($price, $quantity, $prod->type_incentive_doctor, (float) $prod->incentive_doctor);
            }
        }

        return 0;
    }

    /**
     * Hitung jumlah rupiah insentif.
     *
     * @param  string  $type  'percentage' | 'rupiah'
     */
    private function computeAmount(int $price, int $quantity, string $type, float $value): int
    {
        $total = $price * $quantity;

        if ($type === 'percentage') {
            return (int) round($total * $value / 100);
        }

        return (int) ($value * $quantity);
    }

    /**
     * Hitung dan simpan insentif rujukan dokter berdasarkan persentase referral.
     *
     * @param string|Transaction $transaction
     * @return void
     */
    public function calculateReferralIncentive(string|Transaction $transaction): void
    {
        if (is_string($transaction)) {
            $transaction = Transaction::findOrFail($transaction);
        }

        $referralDoctorId = $transaction->doctor_referral_id;
        if (!$referralDoctorId) {
            return;
        }

        $doctor = \App\Models\User::with('userDetail')->find($referralDoctorId);
        if (!$doctor || !$doctor->userDetail) {
            Log::info('DoctorIncentiveService (Referral): Doctor or userDetail not found', ['user_id' => $referralDoctorId]);
            return;
        }

        $referralPercentage = $doctor->userDetail->referral_percentage ?? 0;
        if ($referralPercentage <= 0) {
            Log::info('DoctorIncentiveService (Referral): Percentage is zero', ['user_id' => $referralDoctorId]);
            return;
        }

        $grandTotal = $transaction->grand_total_price ?? 0;
        if ($grandTotal <= 0) {
            return;
        }

        $incentiveAmount = (int) round(($grandTotal * $referralPercentage) / 100);

        if ($incentiveAmount > 0) {
            $month = $transaction->created_at->format('m');
            $year  = $transaction->created_at->format('Y');

            UserIncentive::updateOrCreate(
                [
                    'transaction_id' => $transaction->id,
                    'user_id'        => $referralDoctorId,
                    'status'         => 'dokter',
                ],
                [
                    'amount'     => $incentiveAmount,
                    'description'=> "Insentif Refferal Dokter dari konsultasi Transaksi #{$transaction?->code}",
                    'month'      => $month,
                    'year'       => $year,
                    'company_id' => $transaction->company_id,
                ]
            );

            Log::info('DoctorIncentiveService (Referral): Incentive saved', [
                'transaction_id' => $transaction->id,
                'user_id'        => $referralDoctorId,
                'amount'         => $incentiveAmount,
            ]);
        }
    }
}
