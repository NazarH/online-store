<?php

namespace App\Actions\Product;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Lorisleiva\Actions\Concerns\AsAction;

class ProductCreateAction
{
    use AsAction;

    /**
     * Обробляє створення продукту.
     *
     * @param Request $request Запит на створення продукту.
     * @return array Дані для відображення форми створення продукту.
     */
    public function handle(Request $request): array
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