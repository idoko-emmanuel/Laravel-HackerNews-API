<?php

namespace Database\Factories;

use App\Models\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Author>
 */
class AuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Author::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->unique()->word(),
            'created' => $this->faker->dateTimeBetween('-10 years', 'now')->format('U'),
            'karma' => $this->faker->numberBetween(0, 1000),
            'about' => $this->faker->optional()->paragraph(),
            'submitted' => json_encode($this->faker->unique()->randomElements(range(1, 999999), $this->faker->numberBetween(1, 20))),
        ];
    }
}
