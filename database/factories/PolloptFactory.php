<?php

namespace Database\Factories;

use App\Models\Pollopt;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pollopt>
 */
class PolloptFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pollopt::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->numberBetween(1, 999999),
            'by' => $this->faker->name(),
            'poll_id' => $this->faker->numberBetween(1, 999999),
            'score' => $this->faker->numberBetween(0, 100),
            'text' => $this->faker->sentence(),
            'time' => $this->faker->unixTime(),
            'deleted' => $this->faker->boolean(),
            'dead' => $this->faker->boolean(),
            'category' => $this->faker->word()
        ];
    }
}
