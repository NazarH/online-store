<?php

namespace App\Actions\Admin\Product;

use App\Models\Brand;
use App\Models\Category;

class ProductCreateAction
{
    public function handle($request)
    {
        $data = $request->validated();

        $category = Category::find($data['category_id']);
        $attributes = $category->attributes()->get();
        $brands = Brand::get()->pluck('name', 'id')->toArray();

        return [
            'attributes' => $attributes,
            'brands' => $brands,
            'category' => $category
        ];
    }
}
