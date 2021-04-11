<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'detail' => $this->faker->text,
            'price' => $this->faker->numberBetween(-10000, 10000),
            'discount' => $this->faker->numberBetween(-10000, 10000),
            'stock' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
