<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Bidder;

class BiddersFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bidder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'inn' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'ogrn' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'snils' => $this->faker->regexify('[A-Za-z0-9]{20}'),
            'address' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'reg_number' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'cpo' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'region_id' => $this->faker->randomNumber(),
            'bidder_type_id' => $this->faker->randomNumber(),
            'bidder_category_id' => $this->faker->randomNumber(),
        ];
    }
}
