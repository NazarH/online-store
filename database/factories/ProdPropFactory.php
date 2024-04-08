<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Property;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProdPropFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $productId = Product::inRandomOrder()->first()->id;
        $propertyId = Property::inRandomOrder()->first()->id;

        return [
            'product_id' => $productId,
            'property_id' => $propertyId
        ];
    }
}
