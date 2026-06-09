<?php

namespace App\Livewire\Admin\Master\Article\Category;

use App\Helpers\AlertHelper;
use App\Models\Article\ArticleCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class AdminMasterArticleCategoryIndex extends Component
{
    use WithPagination;
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    public $search = '';

    public $perPage = 10;
    public $data_id;
    public $name;
    public $description;

    public function edit($id)
    {
        $category = ArticleCategory::findOrFail($id);
        $this->data_id = $category->id;
        $this->name = $category->name;
        $this->description = $category->description;

        $this->dispatch('open-modal', ['id' => 'modal']);
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama kategori wajib diisi',
        ]);

        try {
            DB::beginTransaction();

            ArticleCategory::updateOrCreate(
                ['id' => $this->data_id],
                [
                    'name' => $this->name,
                    'slug' => Str::slug($this->name),
                    'description' => $this->description,
                    'company_id' => auth()->user()->company_id,
                ]
            );

            DB::commit();
            $this->dispatch('close-modal', ['id' => 'modal']);
            $this->reset(['data_id', 'name', 'description']);
            return AlertHelper::success('Berhasil', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving article category', [
                'id' => $this->data_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menyimpan data.');
        }
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus data ini?', $id);
    }

    public function delete($data)
    {
        $itemId = $data[0];

        try {
            DB::beginTransaction();

            $category = ArticleCategory::findOrFail($itemId);
            if ($category) {
                $category->delete();

                DB::commit();
                return AlertHelper::success('Berhasil', 'Data berhasil dihapus.');
            }

            DB::rollBack();
            return AlertHelper::error('Gagal', 'Data tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting article category', [
                'id' => $itemId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus data.');
        }
    }

    public function closeModal($modalId)
    {
        $this->resetValidation();
        $this->reset(['data_id', 'name', 'description']);
        $this->dispatch('close-modal', ['id' => $modalId]);
    }

    public function openModal($modalId)
    {
        $this->dispatch('open-modal', ['id' => $modalId]);
    }

    public function render()
    {
        $categories = ArticleCategory::search($this->search)
            ->where('company_id', auth()->user()->company_id)
            ->latest();

        return view('livewire.admin.master.article.category.admin-master-article-category-index', [
            'categories' => $categories->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
