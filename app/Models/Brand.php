<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Brand extends Model
{
    use HasFactory, SlugTrait, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Відношення "один до одного" для отримання фотографії бренду.
     *
     * @return HasOne
     */
    public function photo(): HasOne
    {
        return $this->hasOne(Photo::class)
            ->where('model_type', '=', get_class($this))
            ->where('model_id', '=', $this->id);
    }

    /**
     * Відношення "один до одного" для отримання SEO-даних бренду.
     *
     * @return HasOne
     */
    public function seo(): HasOne
    {
        return $this->hasOne(Seo::class)
            ->where('model_type', '=', get_class($this))
            ->where('model_id', '=', $this->id);
    }

    /**
     * Відношення "один до багатьох" для отримання продуктів бренду.
     *
     * @return HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class, 'brand_id', 'id');
    }
}
