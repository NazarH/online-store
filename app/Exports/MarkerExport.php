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
                            return $property->attribute()->first()->name.': '.$property->value;
                        }
                    )->toArray()),
                    'Brand' => $product->brand->name ?? '',
                    'Category' => $product->category->name ?? '',
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
            'Category'
        ];
    }
}
