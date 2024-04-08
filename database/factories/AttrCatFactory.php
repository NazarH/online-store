<?php

namespace Database\Factories;

use App\Models\Attribute;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AttrCatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $attributeId = Attribute::inRandomOrder()->first()->id;
        $categoryId = Category::inRandomOrder()->first()->id;

        return [
            'attribute_id' => $attributeId,
            'category_id' => $categoryId
        ];
    }
}
