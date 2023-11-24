<?php

namespace Database\Factories;

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
        return [
            'name' => fake()->words(3, true),
            'price' => fake()->numberBetween(100, 1000),
            'stock' => fake()->numberBetween(1, 10),
            'image_path' => fake()->imageUrl(),
        ];
    }

    /**
     * Indicate that the product has a specific price.
     *
     * @return \Database\Factories\ProductFactory
     */
    public function withStock(int $stock): static
    {
        return $this->state(['stock' => $stock]);
    }
}
