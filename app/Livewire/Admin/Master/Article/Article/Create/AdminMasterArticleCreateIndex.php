<?php

namespace App\Livewire\Admin\Master\Article\Article\Create;

use App\Helpers\AlertHelper;
use App\Models\Article\Article;
use App\Models\Article\ArticleCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdminMasterArticleCreateIndex extends Component
{
    use WithFileUploads;

    public $article_id;

    public $title;

    public $content;

    public $article_category_id;

    public $banner;

    public $new_banner;

    public $is_published = false;

    public function mount($id = null)
    {
        if ($id) {
            $article = Article::findOrFail($id);
            $this->article_id = $article->id;
            $this->title = $article->title;
            $this->content = $article->content;
            $this->article_category_id = $article->article_category_id;
            $this->banner = $article->banner;
            $this->is_published = $article->is_published;
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'content' => 'required',
            'article_category_id' => 'required|exists:article_categories,id',
            'new_banner' => 'nullable|image|max:2048', // 2MB Max
        ], [
            'title.required' => 'Judul artikel wajib diisi',
            'content.required' => 'Konten artikel wajib diisi',
            'article_category_id.required' => 'Kategori artikel wajib dipilih',
            'new_banner.image' => 'File harus berupa gambar',
            'new_banner.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        try {
            DB::beginTransaction();

            $bannerPath = $this->banner;
            if ($this->new_banner) {
                // Delete old banner if exists
                if ($this->banner && Storage::exists('public/'.$this->banner)) {
                    Storage::delete('public/'.$this->banner);
                }
                // Store new banner
                $bannerPath = $this->new_banner->store('articles/banners', 'public');
            }

            Article::updateOrCreate(
                ['id' => $this->article_id],
                [
                    'company_id' => auth()->user()->company_id,
                    'article_category_id' => $this->article_category_id,
                    'title' => $this->title,
                    'slug' => Str::slug($this->title),
                    'content' => $this->content,
                    'banner' => $bannerPath,
                    'is_published' => $this->is_published,
                    'published_at' => $this->is_published ? now() : null,
                ]
            );

            DB::commit();

            return redirect()->route('user.master.article.index')->with('success', 'Artikel berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving article', [
                'id' => $this->article_id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return AlertHelper::error('Gagal', 'Terjadi kesalahan saat menyimpan artikel.');
        }
    }

    public function render()
    {
        return view('livewire.admin.master.article.article.create.admin-master-article-create-index', [
            'categories' => ArticleCategory::where('company_id', auth()->user()->company_id)->get(),
        ])
            ->extends('layout.app')
            ->section('content');
    }
}
