<?php

namespace App\Livewire\Admin\Master\Article\Article;

use App\Helpers\AlertHelper;
use App\Models\Article\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithPagination;

class AdminMasterArticleIndex extends Component
{
    use WithPagination;
    protected $queryString = [
        'search' => ['except' => ''],
    ];
    public $search = '';
    public $perPage = 10;

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedPerPage()
    {
        $this->resetPage();
    }

    public function confirmDelete($id)
    {
        return AlertHelper::confirmDelete('delete', 'Apakah Anda yakin ingin menghapus artikel ini?', $id);
    }

    public function delete($data)
    {
        $itemId = $data[0];

        try {
            DB::beginTransaction();

            $article = Article::findOrFail($itemId);
            if ($article) {
                $article->delete();

                DB::commit();
                return AlertHelper::success('Berhasil', 'Artikel berhasil dihapus.');
            }

            DB::rollBack();
            return AlertHelper::error('Gagal', 'Artikel tidak ditemukan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting article', [
                'id' => $itemId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menghapus artikel.');
        }
    }

    public function render()
    {
        $articles = Article::search($this->search)
            ->where('company_id', auth()->user()->company_id)
            ->with('category')
            ->latest();

        return view('livewire.admin.master.article.article.admin-master-article-index', [
            'articles' => $articles->paginate($this->perPage),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
