<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Auction;

class AuctionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Auction::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'number' => $this->faker->numberBetween(-10000, 10000),
            'publish_date' => $this->faker->dateTime(),
            'debitor_id' => $this->faker->randomNumber(),
            'arbitration_manager_id' => $this->faker->randomNumber(),
            'organizer_id' => $this->faker->randomNumber(),
            'trading_platform_id' => $this->faker->randomNumber(),
            'auction_type_id' => $this->faker->randomNumber(),
            'event_period' => '{}',
            'application_period' => '{}',
            'result_date' => $this->faker->dateTime(),
        ];
    }
}
