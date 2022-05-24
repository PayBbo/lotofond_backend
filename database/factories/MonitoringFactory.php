<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Monitoring;

class MonitoringFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Monitoring::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'title' => $this->faker->sentence(4),
            'not_frequency' => $this->faker->numberBetween(-10000, 10000),
            'unnecessary_words' => '{}',
            'right_words' => '{}',
        ];
    }
}
