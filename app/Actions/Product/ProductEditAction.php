<?php

namespace App\Actions\Product;

use App\Models\Brand;
use App\Models\Product;
use Lorisleiva\Actions\Concerns\AsAction;

class ProductEditAction
{
    use AsAction;

    /**
     * Обробляє редагування продукту.
     *
     * @param Product $product Продукт для редагування.
     * @return array Дані для відображення форми редагування продукту.
     */
    public function handle(Product $product): array
    {
        $brands = Brand::get()->pluck('name', 'id')->toArray();
        $attributes = $product->category?->attributes()->get();

        return [
            'product' => $product,
            'brands' => $brands,
            'attributes' => $attributes,
            'images' =>$product->getMedia('images')
        ];
    }
}
