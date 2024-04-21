<?php

namespace App\Actions\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class BrandStoreAction
{
    use AsAction;

    /**
     * Обробляє створення нового бренду.
     *
     * @param array $data Дані для створення бренду.
     * @return void
     */
    public function handle(array $data): Brand
    {
        $data['slug'] = Str::slug($data['name']);

        return Brand::create($data);
    }
}
