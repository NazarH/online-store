<?php

namespace App\Actions\Admin\Product;

use App\Models\Product;

class ProductStoreAction
{
    public function handle($data)
    {
        $data['article'] = uniqid();

        Product::create($data)->properties()->sync($data['properties']);
    }
}
