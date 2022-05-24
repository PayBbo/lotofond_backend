<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Note;

class NoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Note::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(4),
            'item_id' => $this->faker->randomNumber(),
            'item_type' => $this->faker->randomElement(["bidder","lot","auction"]),
            'user_id' => $this->faker->randomNumber(),
        ];
    }
}
