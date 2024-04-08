<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait SlugTrait
{
    public static function bootSlugTrait()
    {
        static::saving(function (Model $model) {
            if (!empty($model->name)) {
                $model->setAttribute('slug', Str::slug($model->name))->saveQuietly();
            }
        });
    }
}
