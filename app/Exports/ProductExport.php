<?php

namespace App\Exports;

use App\Models\Product;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    /**
     * @return Collection
     */
    public function collection(): Collection
    {
        return Product::query()
            ->with(['brand', 'category', 'properties'])
            ->get()
            ->map(function ($product) {
                return [
                    'Name' => $product->name,
                    'Article' => $product->article,
                    'Price' => $product->price,
                    'Price_Old' => $product->old_price,
                    'Attributes' => implode(' | ', $product->properties->map(function ($property) {
                        $name = optional($property->attribute)->name ?: '';
                        return $name . ': ' . $property->value;
                    })->toArray()),
                    'Brand' => $product->brand?->name ?? '',
                    'Category' => $product->category?->name ?? '',
                    'Images' => collect($product->getMedia('images')->all())->map(function($item){
                        return $item->getUrl('thumb');
                    })
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
