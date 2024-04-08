<?php

namespace App\Actions\Admin\Product;

use App\Models\Brand;

class ProductEditAction
{
    public function handle($product)
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
