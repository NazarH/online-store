<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categoryId = Category::inRandomOrder()->first()->id;
        $brandId = Brand::inRandomOrder()->first()->id;

        return [
            'name' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 19999),
            'old_price' => $this->faker->numberBetween(100, 19999),
            'article' => $this->faker->unique()->randomNumber(8),
            'count' => $this->faker->numberBetween(1, 100),
            'slug' => $this->faker->sentence,
            'category_id' => $categoryId,
            'brand_id' => $brandId
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            for ($i = 0; $i < 3; $i++) {
                $imageName = 'image_' . $i . '.jpg';

                $product->addMediaFromUrl('https://picsum.photos/460/460')
                    ->usingFileName($imageName)
                    ->toMediaCollection('images');
            }
        });
    }
}
