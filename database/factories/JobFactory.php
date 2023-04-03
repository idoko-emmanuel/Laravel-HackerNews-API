<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HackerJob::class;

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
            'score' => $this->faker->numberBetween(0, 100),
            'text' => $this->faker->optional()->sentence(),
            'time' => $this->faker->unixTime(),
            'title' => $this->faker->optional()->sentence(),
            'url' => $this->faker->optional()->url(),
            'deleted' => $this->faker->boolean(),
            'dead' => $this->faker->boolean(),
        ];
    }
}
