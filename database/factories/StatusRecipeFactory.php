<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\StatusRecipe>
 */
class StatusRecipeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status_recipes_id' => $this->faker->unique()->randomNumber(), // ID unik untuk setiap status
            'name' => $this->faker->word(), // Nama status (contoh: "Approved", "Pending", "decline")
        ];
    }
}
