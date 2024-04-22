<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Fomvasss\Seo\Models\HasSeo;
use Fomvasss\MediaLibraryExtension\HasMedia\HasMedia;
use Fomvasss\MediaLibraryExtension\HasMedia\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, SlugTrait, HasSeo, InteractsWithMedia;

    protected $guarded = ['id'];
    protected array $mediaSingleCollections = ['images'];
    protected array $mediaMultipleCollections = ['images'];
    /**
     * Повертає масив значень тегів SEO за замовчуванням для продукту.
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
     * Відношення "один до одного" до категорії, до якої належить продукт.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Відношення "один до одного" до бренду, до якого належить продукт.
     *
     * @return BelongsTo
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Повертає атрибути, що відносяться до категорії, до якої належить продукт.
     *
     * @return BelongsToMany
     */
    public function attributes(): BelongsToMany
    {
        return $this->category->attributes();
    }

    /**
     * Відношення "багато до багатьох" до властивостей продукту.
     *
     * @return BelongsToMany
     */
    public function properties(): BelongsToMany
    {
        return $this->belongsToMany(Property::class, 'product_properties');
    }

    /**
     * Scope-запит для фільтрації продуктів за параметрами, переданими через запит.
     *
     * @param  Builder  $query
     * @return void
     */
    public function scopeFilter(Builder $query): void
    {
        $params = Request::except(['_token']);

        foreach ($params as $key => $value) {
            if (!empty($value)) {
                switch ($key) {
                    case 'category':
                        $query->whereIn('category_id', Arr::wrap($value));
                        break;
                    case 'brand':
                        $query->whereIn('brand_id', Arr::wrap($value));
                        break;
                    case 'min_price':
                        $query->where('price', '>=', $value);
                        break;
                    case 'max_price':
                        $query->where('price', '<=', $value);
                        break;
                    default:
                        break;
                }
            }
        }
    }

    /**
     * Відношення "один до багатьох" до відгуків, що належать продукту.
     *
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Comment::class, 'product_id', 'id');
    }
}
