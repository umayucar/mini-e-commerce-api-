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
    public function definition()
    {
        $colors = ['Red', 'Blue', 'Green', 'Yellow', 'Black', 'White', 'Purple', 'Pink'];
        $products = [
            'Men\'s Casual Shirt',
            'Women\'s Summer Dress',
            'Sporty Jogging Pants',
            'Leather Jacket',
            'Wool Sweater',
            'Running Shoes',
            'Denim Jeans',
            'Fleece Hoodie',
            'Cotton T-Shirt',
            'Slim Fit Trousers'
        ];

        return [
            'name' => $this->faker->colorName() . ' ' . $this->faker->randomElement($products),
            'price' => $this->faker->randomFloat(2, 100, 1000),
        ];
    }
}
