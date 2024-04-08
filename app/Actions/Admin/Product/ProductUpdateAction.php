<?php

namespace App\Actions\Admin\Product;

use App\Models\Product;

class ProductUpdateAction
{
    public function handle($data, $product)
    {
        $product->update($data);
        Product::find($product->id)->properties()->sync($data['properties']);
    }
}
