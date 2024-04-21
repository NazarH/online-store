<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MarkerExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Product::query()
            ->with(['brand', 'category'])
            ->get()
            ->map(function ($product) {
                return [
                    'Name' => $product->name,
                    'Article' => $product->article,
                    'Price' => $product->price,
                    'Price_Old' => $product->old_price,
                    'Attributes' => implode(' | ', $product->properties()->get()->map(
                        function ($property) {
                            $name = !empty($property->attribute()->first()->name) ? $property->attribute()->first()->name : '';

                            return $name.': '.$property->value;
                        }
                    )->toArray()),
                    'Brand' => $product->brand->name ?? '',
                    'Category' => $product->category->name ?? '',
                    'Images' => !empty($product->images()->first()) ? implode(' | ', $product->images()->get()->map(
                        function ($image) {
                            return $image->name;
                        }
                    )->toArray()) : '',
                ];
            });
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'Name',
            'Article',
            'Price',
            'Price_Old',
            'Attributes',
            'Brand',
            'Category',
            'Images'
        ];
    }
}
