<?php

namespace App\Models;

use App\Traits\SlugTrait;
use Fomvasss\Seo\Models\HasSeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaticPage extends Model
{
    use HasFactory,
        SoftDeletes,
        SlugTrait,
        HasSeo;

    protected $guarded = ['id'];

    /**
     * Повертає масив значень тегів SEO за замовчуванням для поточного об'єкту моделі.
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
}
