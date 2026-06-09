<?php

namespace App\Models\SystemUpdate;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SystemUpdate extends Model
{
    use HasUuids, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', '%' . $search . '%')
                    ->orWhere('content', 'ilike', '%' . $search . '%');
            });
        }
        return $query;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $lastOrder = static::max('order');
            $model->order = $lastOrder ? $lastOrder + 1 : 1;

            if (!$model->published_at) {
                $model->published_at = now();
            }
        });
    }

    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'info' => 'blue',
            'warning' => 'yellow',
            'success' => 'green',
            'danger' => 'red',
            default => 'gray',
        };
    }

    public function getTypeIconAttribute()
    {
        return match($this->type) {
            'info' => 'fa-info-circle',
            'warning' => 'fa-exclamation-triangle',
            'success' => 'fa-check-circle',
            'danger' => 'fa-exclamation-circle',
            default => 'fa-bell',
        };
    }
}
