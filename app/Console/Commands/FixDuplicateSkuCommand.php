<?php

namespace App\Console\Commands;

use App\Models\Product\Product;
use Illuminate\Console\Command;

class FixDuplicateSkuCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:fix-duplicate-sku
                            {--company= : Specific company ID to fix}
                            {--prefix=PRO : Prefix for auto-generated SKUs}
                            {--dry-run : Show what would be changed without actually changing}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix duplicate SKU numbers, remove spaces, and auto-generate missing SKUs';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        $companyId = $this->option('company');
        $prefix = $this->option('prefix') ?: 'PRO';

        $this->info('🔍 Memulai proses perbaikan SKU...');
        $this->newLine();

        $query = Product::query();

        if ($companyId) {
            $query->where('company_id', $companyId);
            $this->info("📌 Filter: Company ID = {$companyId}");
        }

        $allProducts = $query->get();
        $totalChanged = 0;
        $changes = [];

        foreach ($allProducts as $product) {
            $oldSku = $product->sku_number;
            $newSku = $oldSku;

            // 1. Hilangkan spasi jika ada
            if ($newSku) {
                $newSku = str_replace(' ', '', $newSku);
            }

            // 2. Generate SKU jika kosong
            if (empty($newSku)) {
                $dynamicPrefix = $this->getPrefixFromName($product->name);
                $newSku = $this->generateNextIncrementalSku($product->company_id, $dynamicPrefix);
            }

            // 3. Pastikan Unik (jika berubah atau memang duplikat)
            if ($newSku !== $oldSku || $this->isSkuDuplicate($newSku, $product->company_id, $product->id)) {
                $newSku = $this->makeSkuUnique($newSku, $product->company_id, $product->id);
            }

            if ($newSku !== $oldSku) {
                $changes[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'old_sku' => $oldSku,
                    'new_sku' => $newSku,
                    'company_id' => $product->company_id,
                ];

                if ($isDryRun) {
                    $this->warn("  → {$product->name} (ID: {$product->id}) - Akan diubah: ".($oldSku ?: '[KOSONG]')." → {$newSku}");
                } else {
                    $product->sku_number = $newSku;
                    $product->save();
                    $this->info("  ✓ {$product->name} (ID: {$product->id}) - Diubah: ".($oldSku ?: '[KOSONG]')." → {$newSku}");
                    $totalChanged++;
                }
            }
        }

        if ($isDryRun) {
            $this->newLine();
            $this->warn('🔸 DRY RUN MODE - Tidak ada perubahan yang disimpan');
            $this->info('📊 Total produk yang akan diubah: '.count($changes));
        } else {
            $this->newLine();
            $this->info("✅ Selesai! Total {$totalChanged} SKU berhasil diperbarui");
            $this->saveChangeLog($changes);
        }

        return Command::SUCCESS;
    }

    /**
     * Cek apakah SKU sudah digunakan oleh produk lain dalam perusahaan yang sama
     */
    private function isSkuDuplicate($sku, $companyId, $excludeProductId)
    {
        return Product::where('sku_number', $sku)
            ->where('company_id', $companyId)
            ->where('id', '!=', $excludeProductId)
            ->exists();
    }

    /**
     * Pastikan SKU unik dengan menambahkan suffix jika perlu
     */
    private function makeSkuUnique($sku, $companyId, $excludeProductId, $attempt = 1)
    {
        $finalSku = $attempt === 1 ? $sku : $sku.'-'.($attempt - 1);

        if ($this->isSkuDuplicate($finalSku, $companyId, $excludeProductId)) {
            return $this->makeSkuUnique($sku, $companyId, $excludeProductId, $attempt + 1);
        }

        return $finalSku;
    }

    /**
     * Ambil 3 huruf pertama dari kata pertama nama produk untuk dijadikan prefix
     */
    private function getPrefixFromName($name)
    {
        $name = trim($name);
        if (empty($name)) {
            return 'PRD';
        }

        // Ambil kata pertama
        $firstWord = explode(' ', $name)[0];

        // Ambil 3 huruf pertama, hilangkan karakter non-alfanumerik, dan uppercase
        $prefix = preg_replace('/[^A-Za-z0-9]/', '', $firstWord);
        $prefix = strtoupper(substr($prefix, 0, 3));

        return ! empty($prefix) ? $prefix : 'PRD';
    }

    /**
     * Generate SKU incremental berikutnya (Prefix001, Prefix002, dst)
     */
    private function generateNextIncrementalSku($companyId, $prefix)
    {
        $lastProduct = Product::where('sku_number', 'ilike', $prefix.'%')
            ->where('company_id', $companyId)
            ->whereRaw("sku_number ~ '^{$prefix}[0-9]+$'") // Gunakan regex untuk memastikan format Prefix + Angka
            ->orderByRaw('LENGTH(sku_number) DESC')
            ->orderBy('sku_number', 'DESC')
            ->first();

        if (! $lastProduct) {
            return $prefix.'001';
        }

        $lastSku = $lastProduct->sku_number;
        $numberPart = str_replace($prefix, '', $lastSku);

        if (! is_numeric($numberPart)) {
            return $prefix.'001';
        }

        $number = (int) $numberPart;
        $nextNumber = str_pad((string) ($number + 1), 3, '0', STR_PAD_LEFT);

        return $prefix.$nextNumber;
    }

    /**
     * Simpan log perubahan ke file
     */
    private function saveChangeLog($changes)
    {
        if (empty($changes)) {
            return;
        }

        $logPath = storage_path('logs/sku_fix_'.now()->format('Y-m-d_His').'.json');
        file_put_contents($logPath, json_encode($changes, JSON_PRETTY_PRINT));

        $this->info("📝 Log perubahan disimpan di: {$logPath}");
    }
}
