<?php

namespace App\Actions\Admin\Category;

use App\Models\Category;

class CategoryOrderAction
{
    /**
     * Обробляє порядок категорій.
     *
     * @param array $data Дані для оновлення порядку категорій.
     * @return void
     */
    public function handle(array $data): void
    {
        $entities = build_linear_array_sort($data);

        foreach ($entities as $item) {
            optional(Category::find($item['id']))->update($item);
        }
    }
}
