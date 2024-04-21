<?php

namespace App\Actions\Brand;

use App\Models\Brand;
use Illuminate\Support\Str;
use Lorisleiva\Actions\Concerns\AsAction;

class BrandUpdateAction
{
    use AsAction;

    /**
     * Обробляє оновлення інформації про бренд.
     *
     * @param array $data Дані для оновлення бренду.
     * @param Brand $brand Бренд, який потрібно оновити.
     * @return void
     */
    public function handle(array $data, Brand $brand): void
    {
        $data['slug'] = Str::slug($data['name']);

        $brand->update($data);
    }
}
