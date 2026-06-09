<?php

namespace App\Livewire\Admin\Master\Service;

use App\Helpers\AlertHelper;
use App\Models\Branch\Branch;
use App\Models\Product\Product;
use App\Models\Product\ProductPrice;
use App\Models\Product\ProductType;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class AdminMasterServiceIndex extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    public $search = '';
    public $perPage = 5;
    public $data_id = null;
    public $name;
    public $description;
    public $hpp_average;
    public $product_type_id;
    public $price;

    public function mount()
    {
        $this->product_type_id = ProductType::where('name', 'Jasa')->first()->id;
    }

    public function openModal()
    {
        return $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function closeModal($modal)
    {
        $this->reset([
            'data_id',
            'name',
            'description',
            'hpp_average',
            'price',
        ]);
        return $this->dispatch('close-modal', ['id' => $modal]);
    }

    public function edit($id)
    {
        $this->data_id = $id;
        $product = Product::find($id);
        if ($product) {
            $this->name = $product->name;
            $this->description = $product->description;
            $this->product_type_id = $product->product_type_id;

            $productPrice = ProductPrice::where('product_id', $id)->where('company_id', auth()->user()->company_id)->where('is_updated', true)->first();
            if ($productPrice) {
                $this->hpp_average = number_format($productPrice->hpp_average, 0, ',', '.');
                $this->price = number_format($productPrice->price, 0, ',', '.');
            }
        }
        $this->openModal();
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'hpp_average' => 'required',
            'price' => 'required',
        ]);

        $product = Product::updateOrCreate(
            ['id' => $this->data_id],
            [
                'name' => $this->name,
                'description' => $this->description,
                'product_type_id' => $this->product_type_id,
                'company_id' => auth()->user()->company_id,
                'is_non_stock' => true,
                'branch_id' => Branch::where('company_id', auth()->user()->company_id)->first()->id ?? null,
            ]
        );

        ProductPrice::updateOrCreate(
            [
                'product_id' => $product->id,
                'company_id' => auth()->user()->company_id,
                'branch_id' => Branch::where('company_id', auth()->user()->company_id)->first()->id ?? null,
            ],
            [
                'hpp_average' => intval(Str::replace('.', '', $this->hpp_average)),
                'price' => intval(Str::replace('.', '', $this->price)),
                'is_updated' => true,
            ]
        );

        $this->closeModal('modal');
        return AlertHelper::success('Berhasil', 'Data Jasa berhasil disimpan.');
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus Jasa ini?', $id);
    }

    public function delete($id)
    {
        $product = Product::find($id[0]);
        if ($product) {
            $product->delete();
            return AlertHelper::success('Berhasil', 'Jasa berhasil dihapus.');
        }
        return AlertHelper::error('Gagal', 'Jasa tidak ditemukan.');
    }

    public function render()
    {
        $products = Product::where('product_type_id', $this->product_type_id)
            ->select('id', 'name', 'description')
            ->where('is_non_stock', true)
            ->with(['productPrice:product_id,hpp_average,price'])
            ->search($this->search)
            ->orderBy('name');

        return view('livewire.admin.master.service.admin-master-service-index', [
            'products' => $products->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
