<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Fomvasss\Seo\Models\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Fomvasss\MediaLibraryExtension\HasMedia\HasMedia;
use Fomvasss\MediaLibraryExtension\HasMedia\InteractsWithMedia;
use Illuminate\Database\Eloquent\Builder;

class Article extends Model implements HasMedia
{
    use HasFactory,
        SoftDeletes,
        SlugTrait,
        HasSeo,
        InteractsWithMedia;

    protected $guarded = ['id'];
    protected array $mediaSingleCollections = ['images'];
    protected array $mediaMultipleCollections = ['images'];

    /**
     * Повертає масив значень тегів SEO за замовчуванням для статті.
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
     * Відношення "один до багатьох" для отримання всіх фотографій, що належать статті.
     *
     * @return HasMany
     */
    public function photos(): HasMany
    {
        return $this->hasMany(Photo::class)
            ->where('model_type', '=', get_class($this))
            ->where('model_id', '=', $this->id);
    }

    /**
     * Відношення "багато до одного" для отримання користувача, який створив статтю.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function seo(?string $group = null): MorphOne
    {
        return $this->morphOne(config('seo.model', Seo::class), 'model')
            ->where('group', $group);
    }

    /**
     * Відношення "один до одного" до категорії, до якої належить стаття.
     *
     * @return BelongsTo
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function mainImage()
    {
        return $this->getMedia('images')->map(function ($image) {
            return $image->getUrl();
        })->first();
    }

}
