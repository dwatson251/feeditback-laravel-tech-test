<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'user_id' => User::factory(),
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl,
            'release_date' => $this->faker->date,
            'rating' => $this->faker->word,
            'award_winning' => $this->faker->boolean,
            'uuid' => $this->faker->uuid,
        ];
    }
}
