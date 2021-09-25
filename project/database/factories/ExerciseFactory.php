<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Exercise;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class ExerciseFactory
 *
 * @package Database\Factories
 */
class ExerciseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exercise::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'category_id' => Category::query()->inRandomOrder()->first()->id
        ];
    }
}
