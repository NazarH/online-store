<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Fomvasss\Seo\Models\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory,
        SoftDeletes,
        SlugTrait,
        HasSeo;

    protected $guarded = ['id'];

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
}
