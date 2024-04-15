<?php

namespace App\Actions\Admin\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;

class BrandStoreAction
{
    /**
     * Обробляє створення нового бренду.
     *
     * @param array $data Дані для створення бренду.
     * @return void
     */
    public function handle(array $data): void
    {
        $data['slug'] = Str::slug($data['name']);

        Brand::create($data);

    }
}
