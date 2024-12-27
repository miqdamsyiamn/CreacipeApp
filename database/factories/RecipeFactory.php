<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Recipe;

class RecipeFactory extends Factory
{
    protected $model = Recipe::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'ingredients' => $this->faker->text,
            'steps' => $this->faker->text,
            'image' => $this->faker->imageUrl(),
            'user_id' => \App\Models\User::factory(),
            'status_recipes_id' => 1, // Default status "Pending"
            'category' => $this->faker->word,
        ];
    }
}
