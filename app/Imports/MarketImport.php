<?php

namespace App\Imports;

use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MarketImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $item) {
            $brand = Brand::firstOrCreate([
                'name' => $item['brand']
            ]);

            $category = Category::firstOrCreate([
               'name' => $item['category']
            ]);

            $product = Product::firstOrCreate([
                'name' => $item['name'],
                'price' => $item['price'],
                'old_price' => $item['price_old'],
                'article' => $item['article'],
                'brand_id' => $brand->id,
                'category_id' => $category->id
            ]);

            if ($item['attributes']) {
                $this->makeAttributes($item, $category, $product);
            }
        }

        return redirect()->route('admin.home');
    }

    /**
     * @param $item
     * @param $category
     * @param $product
     */
    private function makeAttributes($item, $category, $product)
    {
        foreach (explode(' | ', $item['attributes']) as $attribute) {
            $arr = explode(': ', $attribute);

            $attribute = Attribute::firstOrCreate([
                'name' => $arr[0]
            ]);

            $attribute->categories()->sync($category->id);

            $property = Property::create([
                'value' => $arr[1],
                'attribute_id' => $attribute->id
            ]);

            $product->properties()->sync($property->id, false);
        }
    }
}


