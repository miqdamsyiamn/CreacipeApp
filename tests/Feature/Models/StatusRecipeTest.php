<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\StatusRecipe;
use App\Models\Recipe;

class StatusRecipeTest extends TestCase
{
    /**
     * Test StatusRecipe model has the correct fillable attributes.
     */
    public function test_status_recipe_fillable_attributes()
    {
        $fillable = ['name'];
        $statusRecipe = new StatusRecipe();

        $this->assertEquals($fillable, $statusRecipe->getFillable());
    }

    /**
     * Test StatusRecipe has many recipes relationship.
     */
    public function test_status_recipe_has_many_recipes()
    {
        // Create a StatusRecipe
        $statusRecipe = StatusRecipe::factory()->create();

        // Create related recipes
        Recipe::factory()->count(3)->create([
            'status_recipes_id' => $statusRecipe->status_recipes_id,
        ]);

        // Verify the relationship
        $this->assertCount(3, $statusRecipe->recipes);

        foreach ($statusRecipe->recipes as $recipe) {
            $this->assertEquals($statusRecipe->status_recipes_id, $recipe->status_recipes_id);
        }
    }
}
