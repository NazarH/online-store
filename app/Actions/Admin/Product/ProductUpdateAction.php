<?php

namespace App\Actions\Admin\Product;

use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class ProductUpdateAction
{
    use AsAction;

    /**
     * Обробляє оновлення інформації про продукт.
     *
     * @param array $data Дані для оновлення продукту.
     * @param Product $product Продукт, який потрібно оновити.
     * @return void
     */
    public function handle(array $data, Product $product): void
    {
        $product->update($data);

        Product::find($product->id)->properties()->sync($data['properties']);
    }
}
