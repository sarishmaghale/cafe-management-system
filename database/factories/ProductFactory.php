<?php

namespace Database\Factories;

use App\Models\Product;
use \Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition()
    {

        return [
            'product_name' => $this->faker->word(),
            'product_price' => $this->faker->randomFloat(2, 1, 1000),
        ];
    }
}
