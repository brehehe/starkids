<?php

namespace App\Traits\Product;

use App\Models\Product\Product;
use App\Models\Product\ProductStockHistory;
use Illuminate\Support\Facades\Auth;

trait ProductStockTrait
{
    /**
     * Get product stocks query with filters
     */
    public function getProductStocksQuery()
    {
        $query = Product::search($this->search)
            ->select('id', 'sku_number', 'name', 'description', 'company_id', 'unit_id', 'maximum_stock', 'minimun_stock', 'safety_stock', 'product_category_id', 'product_factory_id', 'product_rack_id', 'product_type_id')
            ->with('company:id,name', 'productStock:id,product_id,branch_id,quantity,quantity_lock,quantity_real,company_id', 'unit:id,name', 'productPrice:id,product_id,price,hpp_average,hpp_average_without_discount,branch_id,company_id')
            ->where('company_id', Auth::user()->company_id);

        // Apply filters
        if (! empty($this->product_category_id)) {
            $query->where('product_category_id', $this->product_category_id);
        }

        if (! empty($this->product_factory_id)) {
            $query->where('product_factory_id', $this->product_factory_id);
        }

        if (! empty($this->product_rack_id)) {
            $query->where('product_rack_id', $this->product_rack_id);
        }

        if (! empty($this->product_type_id)) {
            $query->where('product_type_id', $this->product_type_id);
        }

        if (method_exists($this, 'getDateRange')) {
            [$startDate, $endDate] = $this->getDateRange();
            if ($startDate && $endDate) {
                $query->whereHas('productStockHistories', function ($q) use ($startDate, $endDate) {
                    $q->whereBetween('created_at', [$startDate.' 00:00:00', $endDate.' 23:59:59']);
                });
            }
        }

        return $query->orderBy('name', 'asc');
    }

    /**
     * Get paginated product stocks
     */
    public function getProductStocks()
    {
        return $this->getProductStocksQuery()->paginate($this->perPage);
    }

    public function getProductStockHistorys($type)
    {
        $productStockHistorys = ProductStockHistory::search(trim($this->search))
            ->with('product:id,name,sku_number,unit_id', 'user:id,name', 'branch:id,name', 'company:id,name', 'product.unit:id,name')
            ->where('type', $type)
            ->where('company_id', Auth::user()->company_id)
            ->orderBy('order', 'desc');

        if ($this->start_date) {
            $productStockHistorys->whereDate('date', '>=', $this->start_date);
        }

        if ($this->end_date) {
            $productStockHistorys->whereDate('date', '<=', $this->end_date);
        }

        if ($this->product_id) {
            $productStockHistorys->where('product_id', $this->product_id);
        }

        return $productStockHistorys->paginate($this->perPage);
    }
}
