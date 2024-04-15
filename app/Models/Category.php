<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Fomvasss\Seo\Models\HasSeo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Request;
use Kalnoy\Nestedset\NodeTrait;

class Category extends Model
{
    use HasFactory,
        SoftDeletes,
        SlugTrait,
        NodeTrait,
        HasSeo;

    protected $guarded = ['id'];

    /**
     * Повертає масив значень тегів SEO за замовчуванням для моделі.
     *
     * @return array
     */
    public function registerSeoDefaultTags(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
        ];
    }

    /**
     * Відношення "багато до багатьох" до атрибутів, які належать моделі.
     *
     * @return BelongsToMany
     */
    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(Attribute::class, 'attribute_category');
    }

    /**
     * Відношення "один до багатьох" до продуктів, які належать моделі.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Scope-запит для вибору моделей з певним батьківським ідентифікатором.
     *
     * @param  Builder  $query
     * @param  int $id
     * @return Builder
     */
    public function scopeParent(Builder $query, int $id): Builder
    {
        return $query->where('parent_id', $id);
    }
}
