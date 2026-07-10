<?php

namespace App\Livewire\Admin\Logistic\StockMutation\Detail;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Company\Company;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductPriceHistory;
use App\Models\Product\ProductStock;
use App\Models\Product\ProductStockHistory;
use App\Models\StockMutation\StockMutation;
use App\Models\StockMutation\StockMutationDetail;
use Auth;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Session;
use Str;

class AdminLogisticStockMutationDetailIndex extends Component
{
    public $companys = [];

    public $data_id;

    public $company_id;

    public $code;

    public $name;

    public $description;

    public $products = [];

    public $details = [];

    public function mount()
    {
        $this->data_id = Session::get('stock_mutation_id');

        if ($this->data_id) {
            $stockMutation = StockMutation::find($this->data_id);
            if ($stockMutation) {
                $this->company_id = $stockMutation->company_branch_id;
                $this->code = $stockMutation->code;
                $this->name = $stockMutation->name;
                $this->description = $stockMutation->description;
            } else {
                AlertHelper::error('Gagal', 'Data tidak ditemukan.');

                return redirect()->route('user.logistic.stock-mutation');
            }
        }

        $this->companys = Company::where('company_id', Auth::user()->company_id)
            ->select('id', 'name')
            ->orderBy('name', 'asc')
            ->get()
            ->pluck('name', 'id')
            ->toArray();
        $this->products = Product::where('company_id', Auth::user()->company_id)
            ->where('is_non_stock', false)
            ->select('id', 'name', 'sku_number')
            ->orderBy('name', 'asc')
            ->get()
            ->pluck('name_sku', 'id')
            ->toArray();
        if ($this->data_id) {
            $this->details = StockMutationDetail::where('stock_mutation_id', $this->data_id)
                ->select('id', 'product_id', 'product_branch_id', 'quantity_system', 'quantity')
                ->get()
                ->map(function ($detail) {
                    return [
                        'product_id' => $detail->product_id,
                        'product_branch_id' => $detail->product_branch_id,
                        'quantity_system' => $detail->quantity_system,
                        'quantity' => number_format($detail->quantity, 0, ',', '.'),
                    ];
                })->toArray();
        } else {
            $this->code = $this->generateUniqueCode();
            $this->addDetail();
        }
    }

    public function addDetail()
    {
        $this->details[] = [
            'product_id' => null,
            'product_branch_id' => null,
            'quantity_system' => 0,
            'quantity' => 0,
        ];
    }

    public function updatedDetails()
    {
        foreach ($this->details as $key => $detail) {
            $product = Product::find($detail['product_id']);
            if (! $product) {
                AlertHelper::error('Gagal', 'Produk tidak ditemukan untuk ID: '.$detail['product_id']);

                continue;
            }

            $productBranch = Product::where('company_id', Auth::user()->company_id)
                ->where('id', $detail['product_id'])
                ->first();

            $productStock = ProductStock::where('company_id', Auth::user()->company_id)
                ->where('product_id', $detail['product_id'])
                ->first();

            $detail['quantity'] = isset($detail['quantity']) ? intval(Str::replace('.', '', $detail['quantity'])) : 0;

            if ($productStock) {
                $detail['quantity_system'] = $productStock->quantity;
            } else {
                $detail['quantity_system'] = 0;
            }

            if ($detail['quantity'] > $this->details[$key]['quantity_system']) {
                AlertHelper::error('Gagal', 'Jumlah yang dimasukkan melebihi stok sistem untuk produk: '.$this->products[$detail['product_id']]);
                $detail['quantity'] = $this->details[$key]['quantity_system'];
            }
            $this->details[$key] = [
                'product_branch_id' => $productBranch ? $productBranch->id : null,
                'product_id' => $detail['product_id'],
                'quantity_system' => $detail['quantity_system'],
                'quantity' => $detail['quantity'],
            ];
        }
    }

    public function confirmDelet($key)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda Yakin Menghapus Ini?', $key);
    }

    public function delete($key)
    {
        try {
            DB::beginTransaction();
            unset($this->details[$key[0]]);
            $this->details = array_values($this->details);
            DB::commit();
            AlertHelper::success('Berhasil', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollBack();
            AlertHelper::error('Gagal', 'Data gagal dihapus: '.$e->getMessage());

            return Log::error('Error deleting stock mutation detail: '.$e->getMessage());
        }
    }

    public function confirmSave()
    {
        return AlertHelper::confirmSave('save', 'Apakah Anda Yakin Menyimpan Ini?');
    }

    public function save()
    {
        $this->validate([
            'code' => 'required|string',
            'company_id' => 'required|exists:companies,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'details.*.product_id' => 'required|exists:products,id',
            'details.*.quantity' => 'required|integer|min:1',
        ], [
            'code.required' => 'Kode harus diisi.',
            'company_id.required' => 'Perusahaan harus dipilih.',
            'name.required' => 'Nama harus diisi.',
            'details.*.product_id.required' => 'Produk harus dipilih.',
            'details.*.quantity.required' => 'Kuantitas harus diisi.',
            'details.*.quantity.integer' => 'Kuantitas harus berupa angka.',
            'details.*.quantity.min' => 'Kuantitas harus lebih besar dari 0.',
        ]);

        try {
            DB::beginTransaction();
            // Here you would typically save the stock mutation details to the database.
            // For example:
            $stockMutation = StockMutation::create([
                'company_id' => Auth::user()->company_id,
                'company_main_id' => Auth::user()->company_id,
                'company_branch_id' => $this->company_id, // Adjust as necessary
                'code' => $this->code,
                'name' => $this->name,
                'description' => $this->description,
                'details' => json_encode($this->details),
            ]);

            foreach ($this->details as $detail) {
                $quantity = $detail['quantity'] ? intval(str_replace('.', '', $detail['quantity'])) : 0;
                $quantity_system = $detail['quantity_system'] ? intval(str_replace('.', '', $detail['quantity_system'])) : 0;
                $branch = Branch::where('company_id', Auth::user()->company_id)
                    ->first();
                $productMain = Product::find($detail['product_id']);
                $productPriceMain = ProductPrice::where('product_id', $productMain->id)
                    ->where('company_id', Auth::user()->company_id)
                    ->first();
                $price = $productPriceMain ? $productPriceMain->hpp_average : 0;

                $product = Product::updateOrCreate(
                    ['id' => $detail['product_branch_id'] ?? null, 'product_id' => $detail['product_id']],
                    [
                        'sku_number' => $productMain->sku_number,
                        'unit_id' => $productMain->unit_id,
                        'name' => $productMain->name,
                        'description' => $productMain->description,
                        'product_category_id' => $productMain->product_category_id,
                        'product_factory_id' => $productMain->product_factory_id,
                        'product_rack_id' => $productMain->product_rack_id,
                        'product_type_id' => $productMain->product_type_id,
                        'registration_path' => $productMain->registration_path ?? 'manual',
                        'is_narcotics' => $productMain->is_narcotics,
                        'is_non_stock' => $productMain->is_non_stock,
                        'medicine_dosage' => $productMain->medicine_dosage ?? 0,
                        'dosage_unit' => $productMain->dosage_unit,
                        'minimun_stock' => $productMain->minimun_stock,
                        'safety_stock' => $productMain->safety_stock,
                        'maximum_stock' => $productMain->maximum_stock,
                        'company_id' => $this->company_id,
                        'code_coding_code' => $productMain->code_coding_code,
                        'form_coding_code' => $productMain->form_coding_code,
                        'item_code' => $productMain->item_code,
                        'item_display' => $productMain->item_display,
                        'numerator_code' => $productMain->numerator_code,
                        'numerator_value' => $productMain->numerator_value,
                        'denominator_code' => $productMain->denominator_code,
                        'denominator_value' => 1,
                        'normal' => $productMain->normal ?? 0,
                    ]
                );

                $stockMutationDetail = StockMutationDetail::create([
                    'stock_mutation_id' => $stockMutation->id,
                    'product_id' => $detail['product_id'],
                    'product_branch_id' => $product->id,
                    'product_name' => $productMain->name,
                    'quantity' => $quantity,
                    'quantity_system' => $quantity_system,
                ]);

                $this->createMutationDataMain($productMain, $branch, $quantity, $price, $stockMutationDetail);
                $this->createMutationData($product, $branch, $quantity, $price, $stockMutationDetail);
            }

            DB::commit();
            session()->flash('saved', [
                'title' => 'Sukses!',
                'text' => 'Data berhasil disimpan!',
            ]);

            return redirect()->route('user.logistic.stock-mutation');
        } catch (\Exception $e) {
            DB::rollBack();
            AlertHelper::error('Gagal', 'Data gagal disimpan: '.$e->getMessage());

            return Log::error('Error saving stock mutation detail: '.$e->getMessage());
        }
    }

    public function createMutationDataMain(Product $product, Branch $branch, int $quantity, float $price, StockMutationDetail $stockMutationDetail): void
    {
        $productStock = ProductStock::where('product_id', $product->id)
            ->where('company_id', Auth::user()->company_id)
            ->where('branch_id', $branch->id)
            ->first();

        if ($productStock) {
            $productStock->quantity -= $quantity;
            $productStock->save();
        } else {
            $productStock = new ProductStock;
            $productStock->product_id = $product->id;
            $productStock->branch_id = $branch->id;
            $productStock->company_id = Auth::user()->company_id;
            $productStock->quantity = $quantity;
            $productStock->save();
        }

        // Generate code: OUT/YYYYMMDD/00001
        $today = date('ymd'); // Tahun 2 digit
        $prefix = 'OUT/'.$today.'/';

        $lastHistory = ProductStockHistory::where('code', 'ilike', $prefix.'%')
            ->where('company_id', Auth::user()->company_id)
            ->where('branch_id', $branch->id)
            ->orderBy('code', 'desc')
            ->first();

        if ($lastHistory && preg_match('/(\d{4})$/', $lastHistory->code, $matches)) {
            $lastNumber = intval($matches[1]);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        $code = $prefix.$nextNumber;

        $description = "Barang keluar: {$quantity} unit pada ".date('d-m-Y')." (Kode: {$code}), harga per unit: {$price}.";

        ProductStockHistory::create([
            'product_id' => $product->id,
            'product_stock_id' => $productStock->id,
            'branch_id' => $branch->id,
            'code' => $code,
            'date' => Carbon::now(),
            'stock_mutation_detail_id' => $stockMutationDetail->id,
            'description' => $description,
            'company_id' => Auth::user()->company_id,
            'quantity' => $quantity,
            'price' => $price,
            'sub_total_price' => $price * $quantity,
            'type' => 'out',
            'user_id' => Auth::user()->id,
        ]);
    }

    public function createMutationData(Product $product, Branch $branch, int $quantity, float $price, StockMutationDetail $stockMutationDetail): void
    {
        $productStock = ProductStock::where('product_id', $product->id)
            ->where('company_id', $this->company_id)
            ->where('branch_id', $branch->id)
            ->first();

        if ($productStock) {
            $productStock->quantity += $quantity;
            $productStock->save();
        } else {
            $productStock = new ProductStock;
            $productStock->product_id = $product->id;
            $productStock->branch_id = $branch->id;
            $productStock->company_id = $this->company_id;
            $productStock->quantity = $quantity;
            $productStock->save();
        }

        // Generate code: IN/YYYYMMDD/00001
        $today = date('ymd'); // Tahun 2 digit
        $prefix = 'IN/'.$today.'/';

        $lastHistory = ProductStockHistory::where('code', 'ilike', $prefix.'%')
            ->where('company_id', $this->company_id)
            ->where('branch_id', $branch->id)
            ->orderBy('code', 'desc')
            ->first();

        if ($lastHistory && preg_match('/(\d{4})$/', $lastHistory->code, $matches)) {
            $lastNumber = intval($matches[1]);
            $nextNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $nextNumber = '0001';
        }

        $code = $prefix.$nextNumber;

        $description = "Barang masuk: {$quantity} unit pada ".date('d-m-Y')." (Kode: {$code}), harga per unit: {$price}.";

        ProductStockHistory::create([
            'product_id' => $product->id,
            'product_stock_id' => $productStock->id,
            'branch_id' => $branch->id,
            'code' => $code,
            'date' => Carbon::now(),
            'stock_mutation_detail_id' => $stockMutationDetail->id,
            'description' => $description,
            'company_id' => $this->company_id,
            'quantity' => $quantity,
            'price' => $price,
            'sub_total_price' => $price * $quantity,
            'type' => 'in',
            'user_id' => Auth::user()->id,
        ]);

        $productPrice = ProductPrice::where('product_id', $product->id)->where('company_id', $this->company_id)->where('branch_id', $branch->id)->first();

        if ($productPrice) {
            $productPrice->price_generate = 0;
            $productPrice->recipe_generate = 0;
            $productPrice->hpp_average = $price;
            $productPrice->is_updated = false;
            $productPrice->save();
        } else {
            $productPrice = new ProductPrice;
            $productPrice->product_id = $product->id;
            $productPrice->branch_id = $branch->id;
            $productPrice->company_id = $this->company_id;
            $productPrice->price_generate = 0;
            $productPrice->recipe_generate = 0;
            $productPrice->hpp_average = $price;
            $productPrice->is_updated = false;
            $productPrice->save();
        }

        ProductPriceHistory::create([
            'product_id' => $product->id,
            'product_price_id' => $productPrice->id,
            'branch_id' => $branch->id,
            'company_id' => $this->company_id,
            'price' => $price,
            'quantity' => $quantity,
            'sub_total_price' => $price * $quantity,
            'hpp_average' => ($price * $quantity) / $quantity,
            'is_updated' => false,
            'user_id' => Auth::user()->id,
        ]);
    }

    public static function generateUniqueCode(string $prefix = 'MS', int $maxRetries = 10): string
    {
        $date = now()->format('ymd');

        // Gunakan database transaction untuk menghindari race condition
        return DB::transaction(function () use ($prefix, $date, $maxRetries) {
            $retry = 0;

            do {
                // Hitung dengan konsisten - termasuk soft deleted
                $count = StockMutation::whereDate('created_at', now()->toDateString())
                    ->count() + 1 + $retry;

                $code = $prefix.$date.str_pad($count, 4, '0', STR_PAD_LEFT);

                // Cek existence dengan lebih robust
                $exists = StockMutation::where('code', $code)
                    ->exists();

                if (! $exists) {
                    return trim($code); // Pastikan tidak ada trailing whitespace
                }

                $retry++;
            } while ($retry < $maxRetries);

            // Fallback ke timestamp microsecond jika semua retry gagal
            return $prefix.$date.'-'.now()->format('His').substr(microtime(), 2, 6);
        });
    }

    public function render()
    {
        return view('livewire.admin.logistic.stock-mutation.detail.admin-logistic-stock-mutation-detail-index')
            ->extends('layout.app')
            ->section('content');
    }
}
