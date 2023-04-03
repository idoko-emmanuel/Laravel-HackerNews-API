<?php

namespace Database\Factories;

use App\Models\Poll;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Poll>
 */
class PollFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Poll::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'by' => $this->faker->name(),
            'descendants' => $this->faker->optional()->numberBetween(0, 100),
            'score' => $this->faker->numberBetween(0, 100),
            'title' => $this->faker->optional()->sentence(),
            'text' => $this->faker->optional()->paragraph(),
            'time' => $this->faker->optional()->unixTime(),
            'deleted' => $this->faker->boolean(),
            'dead' => $this->faker->boolean(),
        ];
    }
}
