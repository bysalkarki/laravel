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
        $money = $this->faker->numberBetween(0, 10000);
        return [
            'title' => $this->faker->sentence(4),
            'detail' => $this->faker->text,
            'price' => $money,
            'discount' => $money - rand(0,$money),
            'stock' => $this->faker->numberBetween(0, 20),
        ];
    }
}
