<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Application;

class ApplicationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Application::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => $this->faker->randomNumber(),
            'lot_id' => $this->faker->randomNumber(),
            'email' => $this->faker->safeEmail,
            'surname' => $this->faker->regexify('[A-Za-z0-9]{255}'),
            'phone' => $this->faker->phoneNumber,
            'for_answer' => $this->faker->randomElement(["vk","viber","whatsapp",""]),
            'answer_date' => $this->faker->dateTime(),
        ];
    }
}
