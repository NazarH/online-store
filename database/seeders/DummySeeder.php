<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Attribute;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Property;
use App\Models\User;
use Database\Factories\AttrCatFactory;
use Database\Factories\ProdPropFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DummySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(30)->create();

        Category::factory()->count(5)->create();
        Brand::factory()->count(5)->create();
        Product::factory()->count(30)->create();
        Attribute::factory()->count(30)->create();

        foreach (Attribute::all() as $item) {
            Property::factory()->create([
                'attribute_id' => $item->id
            ]);
        }

        foreach (Category::all() as $category) {
            $attributes = Attribute::inRandomOrder()->take(10)->get();

            foreach ($attributes as $attribute) {
                $category->attributes()->attach($attribute->id);
            }
        }

        foreach (Product::all() as $product) {
            foreach ($product->attributes as $attribute) {
                $propertyId = $attribute->properties()->inRandomOrder()->first()->id;
                $product->properties()->attach($propertyId);
            }
        }

        foreach (User::all() as $user) {
            Order::factory()->count(rand(1, 5))->create([
                    'user_id' => $user->id,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'name' => $user->name
            ]);
        }

        Article::factory()->count(30)->create();
    }
}
