<?php

namespace Tests\Feature\Models;

use Tests\TestCase;
use App\Models\Recipe;
use App\Models\User;
use App\Models\StatusRecipe;

class RecipeTest extends TestCase
{
    /**
     * Test Recipe model has the correct fillable attributes.
     */
    public function test_recipe_fillable_attributes()
    {
        $fillable = [
            'title',
            'description',
            'ingredients',
            'steps',
            'image',
            'user_id',
            'status_recipes_id',
            'accepted_date',
            'declined_date',
            'decline_reason',
            'category',
        ];

        $this->assertEquals($fillable, (new Recipe)->getFillable());
    }

    /**
     * Test Recipe belongs to User.
     */
    public function test_recipe_belongs_to_user()
    {
        $user = User::factory()->create();
        $recipe = Recipe::factory()->create(['user_id' => $user->user_id]);

        $this->assertInstanceOf(User::class, $recipe->user);
        $this->assertEquals($user->user_id, $recipe->user->user_id);
    }

    /**
     * Test Recipe belongs to StatusRecipe.
     */
    public function test_recipe_belongs_to_status_recipe()
    {
        $status = StatusRecipe::factory()->create();
        $recipe = Recipe::factory()->create(['status_recipes_id' => $status->status_recipes_id]);

        $this->assertInstanceOf(StatusRecipe::class, $recipe->status);
        $this->assertEquals($status->status_recipes_id, $recipe->status->status_recipes_id);
    }
}
