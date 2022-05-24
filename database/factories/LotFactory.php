<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Lot;

class LotFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Lot::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->numberBetween(-10000, 10000),
            'address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'images' => '{}',
            'price' => $this->faker->numberBetween(-100000, 100000),
            'auction_step' => $this->faker->numberBetween(-100000, 100000),
            'deposit' => $this->faker->numberBetween(-100000, 100000),
            'description' => $this->faker->text,
            'is_ecp' => $this->faker->boolean,
            'title' => $this->faker->sentence(4),
            'files' => '{}',
            'category_id' => $this->faker->randomNumber(),
            'status_id' => $this->faker->randomNumber(),
        ];
    }
}
