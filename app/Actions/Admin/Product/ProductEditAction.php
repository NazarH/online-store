<?php

namespace App\Actions\Admin\Product;

use App\Models\Brand;
use App\Models\Product;

class ProductEditAction
{
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
            'attributes' => $attributes
        ];
    }
}
