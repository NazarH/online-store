<?php

namespace App\Actions\Admin\Product;

use App\Models\Product;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsAction;

class ProductStoreAction
{
    use AsAction;

    /**
     * Обробляє створення продукту.
     *
     * @param array $data Дані для створення продукту.
     * @return Product
     */
    public function handle(array $data): Product
    {
        $data['article'] = uniqid();

        $product = Product::create($data);

        $product->properties()->sync($data['properties']);

        if (!empty($data['seo'])) {
            $product->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return $product;
    }
}
