<?php

namespace App\Actions\Product;

use App\Models\Product;
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
        dd($data);
        $data['article'] = uniqid();

        $product = Product::create($data);

        $product->properties()->sync($data['properties']);

        if (!empty($data['seo'])) {
            $product->seo()->updateOrCreate(['tags' => $data['seo']]);
        }

        return $product;
    }
}
