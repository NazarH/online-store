<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->sentence;

        return [
            'name' => $name,
            'text' => $this->faker->paragraphs(rand(1, 5), true),
            'template' => $this->faker->randomElement(['tech', 'standard']),
            'user_id' => User::byAdmin()->inRandomOrder()->first()->id,
            'slug' => Str::slug($name),
        ];
    }
}
