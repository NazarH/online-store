<?php

namespace App\Models;

use GuzzleHttp\Psr7\Query;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    /**
     * Відношення "один до багатьох" для властивостей атрибута.
     *
     * @return HasMany
     */
    public function properties(): HasMany
    {
        return $this->hasMany(Property::class);
    }

    /**
     * Відношення "багато до багатьох" для категорій, яким належить атрибут.
     *
     * @return BelongsToMany
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'attribute_category');
    }

    /**
     * Повертає масив ідентифікаторів категорій, до яких належить атрибут.
     *
     * @return array
     */
    public function belongsToCategories(): array
    {
        return $this->categories()->pluck('id')->toArray();
    }
}
