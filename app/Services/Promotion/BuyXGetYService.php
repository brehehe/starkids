<?php

namespace App\Services\Promotion;

use App\Helpers\AlertHelper;
use App\Models\Promotion\PromotionSimplified;
use App\Models\Transaction\TransactionDetail;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Branch\Branch;
use App\Models\Product\ProductStock;
use App\Models\Transaction\TransactionRecipe;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BuyXGetYService
{
    private $validStatuses = [
        'draft_consultation',
        'waiting_consultation',
        'call_consultation',
        'confirmation_call',
        'consultation',
        'pharmacy',
        'call_pharmacy',
        'sale_pharmacy',
        'draft',
        'process',
        'take_medicine',
    ];

    /**
     * Apply Buy X Get Y promotions to cart items
     */
    public function applyBuyXGetYPromotions($transactionId, $companyId = null)
    {
        try {
            // Get company_id with proper fallback
            if (!$companyId) {
                $user = Auth::user();
                if ($user) {
                    $companyId = $user->company_id;
                } else {
                    // Fallback: get company_id from transaction
                    $transaction = \App\Models\Transaction\Transaction::find($transactionId);
                    $companyId = $transaction ? $transaction->company_id : null;
                }
            }

            if (!$companyId) {
                throw new \Exception('Company ID not found');
            }

            // First, cleanup invalid free items
            $this->cleanupInvalidFreeItems($transactionId);

            // Then consolidate existing duplicate free items
            $consolidationResult = $this->consolidateExistingFreeItems($transactionId);

            // Get active Buy X Get Y promotions
            $promotions = $this->getActiveBuyXGetYPromotions($companyId);
            if ($promotions->isEmpty()) {
                if ($consolidationResult['consolidated']) {
                    return [
                        'success' => true,
                        'message' => $consolidationResult['message'],
                        'applied_promotions' => [$consolidationResult]
                    ];
                }
                return ['success' => true, 'message' => 'No active promotions found', 'applied_promotions' => []];
            }

            $appliedPromotions = [];
            if ($consolidationResult['consolidated']) {
                $appliedPromotions[] = $consolidationResult;
            }

            foreach ($promotions as $promotion) {
                $result = $this->applyPromotionToTransaction($promotion, $transactionId);
                if ($result['applied']) {
                    $appliedPromotions[] = $result;
                }
            }

            // Final consolidation after applying promotions
            $finalConsolidation = $this->consolidateExistingFreeItems($transactionId);
            if ($finalConsolidation['consolidated']) {
                $appliedPromotions[] = $finalConsolidation;
            }

            return [
                'success' => true,
                'applied_promotions' => $appliedPromotions,
                'message' => count($appliedPromotions) > 0
                    ? 'Promosi berhasil diterapkan'
                    : 'Tidak ada promosi yang memenuhi syarat'
            ];
        } catch (\Exception $e) {
            Log::error('BuyXGetY Service Error: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'company_id' => $companyId,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat menerapkan promosi: ' . $e->getMessage(),
                'applied_promotions' => []
            ];
        }
    }

    /**
     * Get active Buy X Get Y promotions
     */
    private function getActiveBuyXGetYPromotions($companyId)
    {
        $promotions = PromotionSimplified::where('type', 'buy_x_get_y')
            ->where('company_id', $companyId)
            ->active()
            ->inDateRange()
            ->inTimeRange()
            ->forToday()
            ->hasQuota()
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('BuyXGetY: Found promotions', [
            'company_id' => $companyId,
            'count' => $promotions->count(),
            'promotions' => $promotions->pluck('name', 'id')->toArray()
        ]);

        return $promotions;
    }

    /**
     * Apply specific promotion to transaction
     */
    public function applyPromotionToTransaction($promotion, $transactionId)
    {
        // Handle different Buy X Get Y configurations
        if (!empty($promotion->buy_x_get_y_rules)) {
            return $this->applyMultipleRules($promotion, $transactionId);
        } else {
            return $this->applySingleRule($promotion, $transactionId);
        }
    }

    /**
     * Apply single Buy X Get Y rule with accumulation
     */
    private function applySingleRule($promotion, $transactionId)
    {
        Log::info('BuyXGetY: Applying single rule', [
            'promotion_id' => $promotion->id,
            'promotion_name' => $promotion->name,
            'transaction_id' => $transactionId
        ]);

        $buyQuantity = $promotion->buy_quantity ?? 1;
        $getQuantity = $promotion->get_quantity ?? 1;

        // Get product IDs from buy_x_get_y_rules JSON or fallback to old columns
        $rules = $promotion->buy_x_get_y_rules ?? [];
        if (is_string($rules)) {
            $rules = json_decode($rules, true) ?? [];
        }

        // If rules is an array of rules, take the first one for simplicity
        if (isset($rules[0])) {
            $rule = $rules[0];
            $buyProductId = $rule['buy_product_id'] ?? null;
            $getProductId = $rule['get_product_id'] ?? $buyProductId;
        } else if (isset($rules['buy_product_id'])) {
            // Single rule format
            $buyProductId = $rules['buy_product_id'];
            $getProductId = $rules['get_product_id'] ?? $buyProductId;
        } else {
            // Fallback to old column format
            $buyProductId = $promotion->buy_product_id ?? null;
            $getProductId = $promotion->get_product_id ?? $buyProductId;
        }

        Log::info('BuyXGetY: Rule configuration', [
            'buy_quantity' => $buyQuantity,
            'get_quantity' => $getQuantity,
            'buy_product_id' => $buyProductId,
            'get_product_id' => $getProductId,
            'raw_rules' => $promotion->buy_x_get_y_rules
        ]);

        if (!$buyProductId) {
            Log::warning('BuyXGetY: No buy_product_id configured', ['promotion_id' => $promotion->id]);
            return ['applied' => false, 'message' => 'Konfigurasi produk tidak valid'];
        }

        // Get eligible transaction details for buy products
        $buyItems = TransactionDetail::where('transaction_id', $transactionId)
            ->whereIn('type_transaction', ['medicine'])
            ->where('product_id', $buyProductId)
            ->whereNull('transaction_detail_id') // Only main items, not free items
            ->get();

        Log::info('BuyXGetY: Found buy items', [
            'count' => $buyItems->count(),
            'items' => $buyItems->pluck('quantity', 'id')->toArray()
        ]);

        if ($buyItems->isEmpty()) {
            return ['applied' => false, 'message' => 'Produk tidak memenuhi syarat promosi'];
        }

        $totalBuyQuantity = $buyItems->sum('quantity');
        $eligibleSets = intval($totalBuyQuantity / $buyQuantity);

        Log::info('BuyXGetY: Calculation', [
            'total_buy_quantity' => $totalBuyQuantity,
            'required_buy_quantity' => $buyQuantity,
            'eligible_sets' => $eligibleSets
        ]);

        if ($eligibleSets <= 0) {
            return [
                'applied' => false,
                'message' => "Minimal beli {$buyQuantity} item untuk mendapat gratis {$getQuantity} item"
            ];
        }

        $totalFreeQuantity = $eligibleSets * $getQuantity;

        // Check if free items already exist and update/consolidate them
        $existingFreeItem = TransactionDetail::where('transaction_id', $transactionId)
            ->whereIn('type_transaction', ['medicine'])
            ->where('product_id', $getProductId)
            ->whereNotNull('transaction_detail_id')
            ->whereNull('product_package_id')
            ->where('is_free_item', true)
            ->whereHas('parentDetail', function ($query) use ($buyProductId) {
                $query->where('product_id', $buyProductId);
            })
            ->first();

        Log::info('BuyXGetY: Free items check', [
            'total_free_quantity_needed' => $totalFreeQuantity,
            'existing_free_item' => $existingFreeItem ? $existingFreeItem->quantity : 0
        ]);

        if ($existingFreeItem) {
            if ($existingFreeItem->quantity == $totalFreeQuantity) {
                return ['applied' => false, 'message' => 'Promosi sudah diterapkan optimal'];
            }

            // Update existing free item quantity
            $existingFreeItem->quantity = $totalFreeQuantity;
            $existingFreeItem->name = $this->generateFreeItemName($getProductId, $promotion, $totalFreeQuantity);
            $existingFreeItem->save();

            Log::info('BuyXGetY: Updated existing free item', [
                'free_item_id' => $existingFreeItem->id,
                'new_quantity' => $totalFreeQuantity
            ]);

            return [
                'applied' => true,
                'promotion_id' => $promotion->id,
                'promotion_name' => $promotion->name,
                'free_quantity' => $totalFreeQuantity,
                'action' => 'updated',
                'message' => "Promosi diperbarui: {$totalFreeQuantity} item gratis dari {$promotion->name}"
            ];
        } else {
            // Create new consolidated free item
            $this->createConsolidatedFreeItem($transactionId, $getProductId, $totalFreeQuantity, $buyItems->first(), $promotion);

            // Increment promotion usage
            $promotion->incrementUsage(Auth::id());

            Log::info('BuyXGetY: Promotion applied successfully', [
                'promotion_id' => $promotion->id,
                'free_items_added' => $totalFreeQuantity
            ]);

            return [
                'applied' => true,
                'promotion_id' => $promotion->id,
                'promotion_name' => $promotion->name,
                'free_quantity' => $totalFreeQuantity,
                'action' => 'created',
                'message' => "Gratis {$totalFreeQuantity} item dari promosi {$promotion->name}"
            ];
        }

        return ['applied' => false, 'message' => 'Promosi sudah optimal'];
    }

    /**
     * Create consolidated free item for buy x get y promotion
     */
    private function createConsolidatedFreeItem($transactionId, $productId, $quantity, $parentItem, $promotion)
    {
        $product = Product::find($productId);
        if (!$product) {
            throw new \Exception("Product with ID {$productId} not found");
        }

        $freeItemName = $this->generateFreeItemName($productId, $promotion, $quantity);

        // Cek apakah sudah ada
        $existingFreeItem = TransactionDetail::where('transaction_id', $transactionId)
            ->whereIn('type_transaction', ['medicine'])
            ->where('transaction_detail_id', $parentItem->id)
            ->where('product_id', $productId)
            ->where('price', 0)
            ->first();

        if ($existingFreeItem) {
            // AKUMULASI quantity - jangan duplikat
            $existingFreeItem->quantity += $quantity;
            $existingFreeItem->save();
        } else {
            // Buat baru
            $freeItem = TransactionDetail::create([
                'transaction_id' => $transactionId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => 0,
                'sub_total_price' => 0,
                'name' => $freeItemName,
                'transaction_detail_id' => $parentItem->id,
                'company_id' => $parentItem->company_id,
                'branch_id' => $parentItem->branch_id,
                'type' => 'single',
                'type_transaction' => $parentItem->type_transaction ?? 'medicine',
                'is_free_item' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            Log::info('BuyXGetY: Created consolidated free item', [
                'free_item_id' => $freeItem->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'parent_item_id' => $parentItem->id
            ]);
        }

        return $freeItem;
    }

    /**
     * Generate descriptive name for free item
     */
    private function generateFreeItemName($productId, $promotion, $quantity)
    {
        $product = Product::find($productId);
        $productName = $product ? $product->name : "Product ID {$productId}";

        return "GRATIS {$quantity}x {$productName} ({$promotion->name})";
    }

    /**
     * Apply multiple Buy X Get Y rules
     */
    private function applyMultipleRules($promotion, $transactionId)
    {
        $appliedRules = [];
        $rules = is_array($promotion->buy_x_get_y_rules) ? $promotion->buy_x_get_y_rules : [];

        foreach ($rules as $rule) {
            $result = $this->applySingleRuleFromArray($rule, $transactionId, $promotion);
            if ($result['applied']) {
                $appliedRules[] = $result;
            }
        }

        if (!empty($appliedRules)) {
            $promotion->incrementUsage(Auth::id());
            return [
                'applied' => true,
                'promotion_id' => $promotion->id,
                'promotion_name' => $promotion->name,
                'applied_rules' => $appliedRules,
                'message' => "Promosi {$promotion->name} berhasil diterapkan"
            ];
        }

        return ['applied' => false, 'message' => 'Tidak ada aturan yang memenuhi syarat'];
    }

    /**
     * Apply single rule from array configuration
     */
    private function applySingleRuleFromArray($rule, $transactionId, $promotion)
    {
        $buyQuantity = $rule['buy_quantity'] ?? 1;
        $getQuantity = $rule['get_quantity'] ?? 1;
        $buyProductId = $rule['buy_product_id'] ?? null;
        $getProductId = $rule['get_product_id'] ?? $buyProductId;

        if (!$buyProductId) {
            return ['applied' => false, 'message' => 'Konfigurasi produk tidak valid'];
        }

        // Get eligible buy items
        $buyItems = TransactionDetail::where('transaction_id', $transactionId)
            ->whereIn('type_transaction', ['medicine'])
            ->where('product_id', $buyProductId)
            ->whereNull('transaction_detail_id')
            ->get();

        if ($buyItems->isEmpty()) {
            return ['applied' => false, 'message' => 'Produk buy tidak ditemukan'];
        }

        $totalBuyQuantity = $buyItems->sum('quantity');
        $eligibleSets = intval($totalBuyQuantity / $buyQuantity);

        if ($eligibleSets <= 0) {
            return ['applied' => false, 'message' => "Minimal beli {$buyQuantity} item"];
        }

        $totalFreeQuantity = $eligibleSets * $getQuantity;

        // Check existing free items for this specific rule
        $existingFreeItems = TransactionDetail::where('transaction_id', $transactionId)
            ->whereIn('type_transaction', ['medicine'])
            ->where('product_id', $getProductId)
            ->whereNotNull('transaction_detail_id')
            ->whereNull('product_package_id')
            ->whereHas('parentDetail', function ($query) use ($buyProductId) {
                $query->where('product_id', $buyProductId);
            })
            ->sum('quantity');

        $freeItemsToAdd = $totalFreeQuantity - $existingFreeItems;

        if ($freeItemsToAdd > 0) {
            $this->createFreeItem($transactionId, $getProductId, $freeItemsToAdd, $buyItems->first(), $promotion);

            return [
                'applied' => true,
                'buy_product_id' => $buyProductId,
                'get_product_id' => $getProductId,
                'free_quantity' => $freeItemsToAdd,
                'message' => "Gratis {$freeItemsToAdd} item"
            ];
        }

        return ['applied' => false, 'message' => 'Sudah optimal untuk aturan ini'];
    }

    /**
     * Create free item in transaction details
     */
    private function createFreeItem($transactionId, $productId, $quantity, $parentItem, $promotion)
    {
        $product = Product::find($productId);
        if (!$product) {
            throw new \Exception("Produk gratis tidak ditemukan: {$productId}");
        }

        if ($product->is_non_stock) {
            throw new \Exception("Produk gratis tidak boleh non-stock: {$product->name}");
        }

        // Get company_id from parent item
        $companyId = $parentItem->company_id;

        // Get product price
        $branchId = $parentItem->transaction->branch_id ??
            Branch::where('company_id', $companyId)->first()->id;

        $productPrice = ProductPrice::where('product_id', $productId)
            ->where('company_id', $companyId)
            ->where('branch_id', $branchId)
            ->where('is_updated', true)
            ->first();

        if (!$productPrice) {
            throw new \Exception("Harga produk gratis tidak ditemukan: {$product->name}");
        }

        $freeItemName = $this->generateFreeItemName($productId, $promotion, $quantity);

        // Create free item
        $existingFreeItem = TransactionDetail::where('transaction_id', $transactionId)
            ->whereIn('type_transaction', ['medicine'])
            ->where('transaction_detail_id', $parentItem->id)
            ->where('product_id', $productId)
            ->where('price', 0)
            ->first();

        if ($existingFreeItem) {
            $existingFreeItem->quantity += $quantity;
            $inputQuantity = intval($existingFreeItem->quantity ?? 1); // Ambil dari Livewire input

            $productStock = ProductStock::where('product_id', $productId)
                ->where('company_id', $companyId)
                ->where('branch_id', $branchId)
                ->first();

            $productId = $transactionItem->product_id ?? $product->id;

            // Hitung locked stock dari transaksi aktif lainnya
            $lockedStock = TransactionDetail::where('product_id', $productId)
                ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                ->when(
                    $existingFreeItem,
                    fn($query) =>
                    $query->where('id', '!=', $existingFreeItem->id)
                )
                ->sum('quantity');

            // Hitung locked stock dari resep aktif
            $lockedStockRecipe = TransactionRecipe::where('product_id', $productId)
                ->whereHas('transaction', fn($query) => $query->whereIn('status', $this->validStatuses))
                ->sum('quantity');

            // Hitung stok tersedia
            $available = $productStock->quantity - $lockedStock - $lockedStockRecipe;

            // Validasi stok
            if ($inputQuantity > $available) {
                return AlertHelper::error(
                    'Gagal',
                    "Stok produk '{$product->name}' tidak mencukupi. Tersedia: {$available}, Dibutuhkan: {$inputQuantity}."
                );
            }

            // AKUMULASI quantity - jangan duplikat
            $existingFreeItem->save();
        } else {
            // Buat baru
            $freeItem = TransactionDetail::create([
                'transaction_id' => $transactionId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => 0,
                'sub_total_price' => 0,
                'name' => $freeItemName,
                'transaction_detail_id' => $parentItem->id,
                'company_id' => $parentItem->company_id,
                'branch_id' => $parentItem->branch_id,
                'type' => 'single',
                'type_transaction' => $parentItem->type_transaction ?? 'medicine',
                'is_free_item' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            Log::info('BuyXGetY: Created consolidated free item', [
                'free_item_id' => $freeItem->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'parent_item_id' => $parentItem->id
            ]);
        }

        Log::info('Buy X Get Y: Free item created', [
            'transaction_id' => $transactionId,
            'product_id' => $productId,
            'quantity' => $quantity,
            'promotion_id' => $promotion->id,
            'parent_item_id' => $parentItem->id
        ]);
    }

    /**
     * Remove Buy X Get Y free items that are no longer valid
     */
    public function validateAndCleanupBuyXGetY($transactionId, $companyId = null)
    {
        try {
            // Get company_id with proper fallback
            if (!$companyId) {
                $user = Auth::user();
                if ($user) {
                    $companyId = $user->company_id;
                } else {
                    // Fallback: get company_id from transaction
                    $transaction = \App\Models\Transaction\Transaction::find($transactionId);
                    $companyId = $transaction ? $transaction->company_id : null;
                }
            }

            if (!$companyId) {
                throw new \Exception('Company ID not found');
            }

            // Get all free items (items with parent)
            $freeItems = TransactionDetail::where('transaction_id', $transactionId)
                ->whereIn('type_transaction', ['medicine'])
                ->whereNotNull('transaction_detail_id')
                ->whereNull('product_package_id')
                ->with(['parentDetail', 'product'])
                ->get();

            $removedItems = [];

            foreach ($freeItems as $freeItem) {
                $parentDetail = $freeItem->parentDetail;

                if (!$parentDetail) {
                    // Parent no longer exists, remove free item
                    $removedItems[] = [
                        'product_name' => $freeItem->product->name ?? 'Unknown',
                        'quantity' => $freeItem->quantity,
                        'reason' => 'Parent item tidak ditemukan'
                    ];
                    $freeItem->delete();
                    continue;
                }

                // Find applicable promotion for this parent-child relationship
                $applicablePromotion = $this->findApplicablePromotion(
                    $parentDetail->product_id,
                    $freeItem->product_id,
                    $companyId
                );

                if (!$applicablePromotion) {
                    // No valid promotion found
                    $removedItems[] = [
                        'product_name' => $freeItem->product->name ?? 'Unknown',
                        'quantity' => $freeItem->quantity,
                        'reason' => 'Promosi tidak aktif atau tidak berlaku'
                    ];
                    $freeItem->delete();
                    continue;
                }

                // Calculate valid free quantity
                $validFreeQuantity = $this->calculateValidFreeQuantity(
                    $applicablePromotion,
                    $parentDetail->product_id,
                    $freeItem->product_id,
                    $transactionId
                );

                if ($freeItem->quantity > $validFreeQuantity) {
                    if ($validFreeQuantity > 0) {
                        // Adjust quantity
                        $removedQuantity = $freeItem->quantity - $validFreeQuantity;
                        $freeItem->update(['quantity' => $validFreeQuantity]);

                        $removedItems[] = [
                            'product_name' => $freeItem->product->name ?? 'Unknown',
                            'quantity' => $removedQuantity,
                            'reason' => 'Jumlah disesuaikan dengan syarat promosi'
                        ];
                    } else {
                        // Remove entirely
                        $removedItems[] = [
                            'product_name' => $freeItem->product->name ?? 'Unknown',
                            'quantity' => $freeItem->quantity,
                            'reason' => 'Tidak memenuhi syarat promosi'
                        ];
                        $freeItem->delete();
                    }
                }
            }

            return [
                'success' => true,
                'removed_items' => $removedItems,
                'message' => count($removedItems) > 0 ? 'Item gratis disesuaikan' : 'Semua item gratis valid'
            ];
        } catch (\Exception $e) {
            Log::error('BuyXGetY Cleanup Error: ' . $e->getMessage(), [
                'transaction_id' => $transactionId,
                'trace' => $e->getTraceAsString()
            ]);

            return [
                'success' => false,
                'message' => 'Terjadi kesalahan saat validasi: ' . $e->getMessage(),
                'removed_items' => []
            ];
        }
    }

    /**
     * Find applicable promotion for product pair
     */
    private function findApplicablePromotion($buyProductId, $getProductId, $companyId)
    {
        return PromotionSimplified::where('type', 'buy_x_get_y')
            ->where('company_id', $companyId)
            ->active()
            ->inDateRange()
            ->inTimeRange()
            ->forToday()
            ->hasQuota()
            ->where(function ($query) use ($buyProductId, $getProductId) {
                // Single rule check
                $query->where(function ($q) use ($buyProductId, $getProductId) {
                    $q->where('buy_product_id', $buyProductId)
                        ->where(function ($sq) use ($getProductId) {
                            $sq->where('get_product_id', $getProductId)
                                ->orWhereNull('get_product_id'); // Same product if null
                        });
                })
                    // Multiple rules check
                    ->orWhereRaw(
                        "JSON_CONTAINS(buy_x_get_y_rules, JSON_OBJECT('buy_product_id', ?, 'get_product_id', ?))",
                        [$buyProductId, $getProductId]
                    );
            })
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Calculate valid free quantity based on promotion rules
     */
    private function calculateValidFreeQuantity($promotion, $buyProductId, $getProductId, $transactionId)
    {
        // Get current buy quantity (excluding free items)
        $buyQuantity = TransactionDetail::where('transaction_id', $transactionId)
            ->whereIn('type_transaction', ['medicine'])
            ->where('product_id', $buyProductId)
            ->whereNull('transaction_detail_id')
            ->sum('quantity');

        // Single rule
        if (empty($promotion->buy_x_get_y_rules)) {
            $requiredBuy = $promotion->buy_quantity ?? 1;
            $freePerSet = $promotion->get_quantity ?? 1;

            $eligibleSets = intval($buyQuantity / $requiredBuy);
            return $eligibleSets * $freePerSet;
        }

        // Multiple rules
        $rules = is_array($promotion->buy_x_get_y_rules) ? $promotion->buy_x_get_y_rules : [];

        foreach ($rules as $rule) {
            if (($rule['buy_product_id'] ?? null) === $buyProductId &&
                ($rule['get_product_id'] ?? null) === $getProductId
            ) {

                $requiredBuy = $rule['buy_quantity'] ?? 1;
                $freePerSet = $rule['get_quantity'] ?? 1;

                $eligibleSets = intval($buyQuantity / $requiredBuy);
                return $eligibleSets * $freePerSet;
            }
        }

        return 0;
    }

    /**
     * Get promotion info for display
     */
    public function getPromotionInfo($transactionId)
    {
        $freeItems = TransactionDetail::where('transaction_id', $transactionId)
            ->whereIn('type_transaction', ['medicine'])
            ->whereNotNull('transaction_detail_id')
            ->whereNull('product_package_id')
            ->with(['product', 'parentDetail.product'])
            ->get();

        $promotionInfo = [];

        foreach ($freeItems as $freeItem) {
            $parentProduct = $freeItem->parentDetail->product ?? null;
            $freeProduct = $freeItem->product;

            $promotionInfo[] = [
                'id' => $freeItem->id,
                'buy_product_name' => $parentProduct->name ?? 'Unknown',
                'get_product_name' => $freeProduct->name ?? 'Unknown',
                'free_quantity' => $freeItem->quantity,
                'original_price' => $freeItem->price_discount ?? 0,
                'savings' => ($freeItem->price_discount ?? 0) * $freeItem->quantity,
                'promotion_text' => $freeItem->name ?? 'Promosi Gratis'
            ];
        }

        return $promotionInfo;
    }

    /**
     * Clean up invalid free items that don't match promotion rules
     */
    private function cleanupInvalidFreeItems($transactionId)
    {
        try {
            $freeItems = TransactionDetail::where('transaction_id', $transactionId)
                ->where('price', 0)
                ->whereIn('type_transaction', ['medicine'])
                ->whereNotNull('transaction_detail_id')
                ->whereNull('product_package_id')
                ->with(['parentDetail', 'product'])
                ->get();


            $removedCount = 0;

            foreach ($freeItems as $freeItem) {
                if (!$freeItem->parentDetail) {
                    // Parent tidak ada, hapus free item
                    $freeItem->delete();
                    $removedCount++;
                    continue;
                }

                // Hitung berapa yang seharusnya gratis berdasarkan quantity parent
                $parentQuantity = $freeItem->parentDetail->quantity;
                $requiredFreeQuantity = $this->calculateRequiredFreeQuantity(
                    $freeItem->parentDetail->product_id,
                    $freeItem->product_id,
                    $parentQuantity
                );

                // Jika free item melebihi yang seharusnya, adjust atau hapus
                if ($freeItem->quantity > $requiredFreeQuantity) {
                    if ($requiredFreeQuantity > 0) {
                        $freeItem->quantity = $requiredFreeQuantity;
                        $freeItem->save();
                    } else {
                        $freeItem->delete();
                        $removedCount++;
                    }
                }
            }

            return $removedCount;
        } catch (\Exception $e) {
            return 0;
        }
    }

    /**
     * Calculate required free quantity based on parent quantity
     */
    private function calculateRequiredFreeQuantity($buyProductId, $getProductId, $parentQuantity)
    {
        // Cari promotion yang berlaku
        $promotion = PromotionSimplified::where('type', 'buy_x_get_y')
            ->active()
            ->inDateRange()
            ->inTimeRange()
            ->forToday()
            ->hasQuota()
            ->first();

        if (!$promotion) {
            return 0;
        }

        $rules = $promotion->buy_x_get_y_rules ?? [];
        if (is_string($rules)) {
            $rules = json_decode($rules, true) ?? [];
        }

        $buyQuantity = 1;
        $getQuantity = 1;

        if (isset($rules[0])) {
            $rule = $rules[0];
            if (($rule['buy_product_id'] ?? null) === $buyProductId &&
                ($rule['get_product_id'] ?? null) === $getProductId
            ) {
                $buyQuantity = $rule['buy_quantity'] ?? 1;
                $getQuantity = $rule['get_quantity'] ?? 1;
            }
        }

        $eligibleSets = intval($parentQuantity / $buyQuantity);
        return $eligibleSets * $getQuantity;
    }

    /**
     * Consolidate existing duplicate free items
     */
    public function consolidateExistingFreeItems($transactionId)
    {
        try {
            $existingFreeItems = TransactionDetail::where('transaction_id', $transactionId)
                ->where('price', 0)
                ->whereIn('type_transaction', ['medicine'])
                ->whereNotNull('transaction_detail_id')
                ->whereNull('product_package_id')
                ->with(['parentDetail', 'product'])
                ->get();

            if ($existingFreeItems->isEmpty()) {
                return ['consolidated' => false, 'message' => 'No free items to consolidate'];
            }

            // Group by product and parent
            $groupedItems = $existingFreeItems->groupBy(function ($item) {
                return $item->product_id . '_' . $item->transaction_detail_id;
            });

            $consolidatedCount = 0;
            $totalSaved = 0;

            foreach ($groupedItems as $items) {
                if ($items->count() > 1) {
                    $totalQuantity = $items->sum('quantity');
                    $keepItem = $items->first();
                    $deleteItems = $items->slice(1);

                    // Update the first item with consolidated quantity
                    $keepItem->quantity = $totalQuantity;
                    $keepItem->name = $this->generateFreeItemName(
                        $keepItem->product_id,
                        (object)['name' => 'Buy X Get Y'],
                        $totalQuantity
                    );
                    $keepItem->save();

                    // Delete duplicate items
                    foreach ($deleteItems as $deleteItem) {
                        $deleteItem->delete();
                        $consolidatedCount++;
                    }

                    $totalSaved += $deleteItems->count();
                }
            }

            if ($consolidatedCount > 0) {
                return [
                    'consolidated' => true,
                    'message' => "Berhasil mengkonsolidasi {$consolidatedCount} item gratis duplikat",
                    'items_consolidated' => $consolidatedCount,
                    'groups_processed' => $groupedItems->count()
                ];
            }

            return ['consolidated' => false, 'message' => 'No duplicate items found to consolidate'];
        } catch (\Exception $e) {
            return [
                'consolidated' => false,
                'message' => 'Error during consolidation: ' . $e->getMessage()
            ];
        }
    }
}
