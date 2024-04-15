<?php

namespace App\Actions\Admin\Product;

use App\Models\Product;

class ProductStoreAction
{
    /**
     * Обробляє створення продукту.
     *
     * @param array $data Дані для створення продукту.
     * @return void
     */
    public function handle(array $data): void
    {
        $data['article'] = uniqid();

        $product = Product::create($data);

        $product->properties()->sync($data['properties']);

        if (!empty($data['seo'])) {
            $product->seo()->updateOrCreate(['tags' => $data['seo']]);
        }
    }
}
