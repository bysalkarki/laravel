<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Review;

class ReviewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'Customer' => $this->faker->text,
            'review' => $this->faker->text,
            'star' => $this->faker->numberBetween(0,5),
            'product_id' => Product::find(rand(1,5)),
        ];
    }
}
