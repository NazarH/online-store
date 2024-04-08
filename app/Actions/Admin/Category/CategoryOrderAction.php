<?php

namespace App\Actions\Admin\Category;

use App\Models\Category;

class CategoryOrderAction
{
    public function handle($data)
    {
        $entities = build_linear_array_sort($data);

        foreach ($entities as $item) {
            optional(Category::find($item['id']))->update($item);
        }
    }
}
