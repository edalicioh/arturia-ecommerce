<?php

namespace Database\Factories;

use Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->word;

        return [
            "name" => $name,
            "slug" =>Str::slug($name),
            "description" => $this->faker->sentence,
            "image" => $this->faker->imageUrl,
            "sale_price" => $this->faker->randomDigit,
            "category_id"=> $this->faker->numberBetween($min = 1, $max = 6),
        ];
    }
}
