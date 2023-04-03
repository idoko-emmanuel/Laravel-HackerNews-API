<?php

namespace Database\Factories;

use App\Models\Story;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Story>
 */
class StoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Story::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category  = ['top', 'new', 'show', 'ask', 'best'];
        return [
            'id' => $this->faker->unique()->randomNumber(),
            'title' => $this->faker->sentence(),
            'url' => $this->faker->url(),
            'text' => $this->faker->paragraph(),
            'score' => $this->faker->numberBetween(0, 100),
            'by' => $this->faker->name(),
            'time' => $this->faker->unixTime(),
            'descendants' => $this->faker->numberBetween(0, 100),
            'deleted' => $this->faker->boolean(),
            'dead' => $this->faker->boolean(),
            'category' => $category[rand(0,4)],
        ];
    }
}
