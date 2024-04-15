<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait SlugTrait
{
    /**
     * Зареєструє обробник події для автоматичного створення слагу перед збереженням моделі.
     *
     * @return void
     */
    public static function bootSlugTrait(): void
    {
        static::saving(function (Model $model) {
            if (!empty($model->name)) {
                $model->setAttribute('slug', Str::slug($model->name))->saveQuietly();
            }
        });
    }
}
