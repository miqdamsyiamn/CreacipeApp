<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\Recipe;
use App\Models\User;

class RecipesControllerTest extends TestCase
{
    use DatabaseTransactions;

    protected function authenticateUser($roles = 'member')
    {
        $user = User::factory()->create(['role_id' => $roles === 'editor' ? 2 : 1]);
        $this->actingAs($user);
        return $user;
    }

    /** @test */
    public function it_can_display_member_recipes()
    {
        $user = $this->authenticateUser();

        Recipe::factory()->count(3)->create([
            'user_id' => $user->user_id,
        ]);

        $response = $this->get(route('member.recipes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('member.recipes.index');
        $response->assertViewHas('recipes');
    }

    /** @test */
    public function it_can_display_create_recipe_form()
    {
        $this->authenticateUser();

        $response = $this->get(route('member.recipes.create'));

        $response->assertStatus(200);
        $response->assertViewIs('member.recipes.create');
    }

    /** @test */
    public function it_can_store_new_recipe()
    {
        $this->authenticateUser();

        Storage::fake('public');

        $data = [
            'title' => 'New Recipe',
            'description' => 'This is a test recipe.',
            'ingredients' => ['Ingredient 1', 'Ingredient 2'],
            'steps' => ['Step 1', 'Step 2'],
            'category' => 'Test Category',
            'image' => UploadedFile::fake()->image('recipe.jpg'),
        ];

        $response = $this->post(route('member.recipes.store'), $data);

        $response->assertRedirect(route('member.recipes.index'));
        $response->assertSessionHas('success', 'Resep berhasil ditambahkan dan menunggu persetujuan.');

        $this->assertDatabaseHas('recipes', [
            'title' => 'New Recipe',
        ]);
    }

    /** @test */
    public function it_can_edit_recipe()
    {
        $user = $this->authenticateUser();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->user_id,
        ]);

        $response = $this->get(route('member.recipes.edit', $recipe->recipe_id));

        $response->assertStatus(200);
        $response->assertViewIs('member.recipes.edit');
        $response->assertViewHas('recipe', $recipe);
    }

    /** @test */
    public function it_can_update_recipe()
    {
        $user = $this->authenticateUser();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->user_id,
        ]);

        Storage::fake('public');

        $data = [
            'title' => 'Updated Recipe',
            'description' => 'Updated description.',
            'ingredients' => ['Updated Ingredient 1', 'Updated Ingredient 2'],
            'steps' => ['Updated Step 1', 'Updated Step 2'],
            'category' => 'Updated Category',
            'image' => UploadedFile::fake()->image('updated_recipe.jpg'),
        ];

        $response = $this->put(route('member.recipes.update', $recipe->recipe_id), $data);

        $response->assertRedirect(route('member.recipes.index'));
        $response->assertSessionHas('success', 'Resep berhasil diperbarui.');

        $this->assertDatabaseHas('recipes', [
            'recipe_id' => $recipe->recipe_id,
            'title' => 'Updated Recipe',
        ]);

        Storage::disk('public')->assertExists('assets/upload/' . $data['image']->hashName());
    }

    /** @test */
    public function it_can_display_approved_recipes_on_home()
    {
        Recipe::factory()->count(5)->create([
            'status_recipes_id' => 2, // Approved status
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertViewIs('home.home');
        $response->assertViewHas('approvedRecipes');
    }

    /** @test */
    public function it_can_display_recipe_details()
    {
        $recipe = Recipe::factory()->create();

        $response = $this->get(route('recipes.show', $recipe->recipe_id));

        $response->assertStatus(200);
        $response->assertViewIs('recipes.show');
        $response->assertViewHas('recipe', $recipe);
    }

    /** @test */
    public function it_can_display_create_recipe_form_by_editor()
    {
        $this->authenticateUser('editor');

        $response = $this->get(route('editor.recipes.create'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.editor.recipes.create');
    }

    /** @test */
    public function it_can_store_recipe_by_editor()
    {
        $this->authenticateUser('editor');

        Storage::fake('public');

        $data = [
            'title' => 'Editor Recipe',
            'description' => 'Recipe created by editor.',
            'ingredients' => ['Ingredient A', 'Ingredient B'],
            'steps' => ['Step A', 'Step B'],
            'category' => 'Editor Category',
            'status' => 2, // Approved
            'image' => UploadedFile::fake()->image('editor_recipe.jpg'),
        ];

        $response = $this->post(route('editor.recipes.store'), $data);

        $response->assertRedirect(route('dashboard.editor.recipes.index'));
        $response->assertSessionHas('success', 'Resep berhasil ditambahkan.');

        $this->assertDatabaseHas('recipes', [
            'title' => 'Editor Recipe',
        ]);

        Storage::disk('public')->assertExists('assets/upload/' . $data['image']->hashName());
    }

    /** @test */
    public function it_displays_decline_message_in_index()
    {
        $user = $this->authenticateUser();

        $recipe = Recipe::factory()->create([
            'user_id' => $user->user_id,
            'status_recipes_id' => 3, // Declined
            'decline_reason' => 'Test decline reason',
        ]);

        $response = $this->get(route('member.recipes.index'));

        $response->assertSessionHas('decline_message', 'Resep "' . $recipe->title . '" ditolak dengan alasan: ' . $recipe->decline_reason);
    }

    /** @test */
    public function it_denies_access_to_edit_other_users_recipe()
    {
        $user = $this->authenticateUser();

        $recipe = Recipe::factory()->create(); // Recipe milik user lain

        $response = $this->get(route('member.recipes.edit', $recipe->recipe_id));

        $response->assertStatus(403);
    }

    /** @test */
    public function it_denies_access_to_update_other_users_recipe()
    {
        $user = $this->authenticateUser();

        $recipe = Recipe::factory()->create(); // Recipe milik user lain

        $response = $this->put(route('member.recipes.update', $recipe->recipe_id), [
            'title' => 'Unauthorized Update',
        ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function it_filters_recipes_by_category_on_home()
    {
        Recipe::factory()->create(['category' => 'Masakan Indonesia', 'status_recipes_id' => 2]);

        $response = $this->get(route('home', ['category' => 'Indonesia']));

        $response->assertStatus(200);
        $response->assertViewHas('approvedRecipes', function ($recipes) {
            return $recipes->first()->category === 'Masakan Indonesia';
        });
    }

    /** @test */
    public function it_filters_recipes_by_foreign_category_on_home()
    {
        Recipe::factory()->create(['category' => 'Masakan Luar Negeri', 'status_recipes_id' => 2]);

        $response = $this->get(route('home', ['category' => 'Luar Negeri']));

        $response->assertStatus(200);
        $response->assertViewHas('approvedRecipes', function ($recipes) {
            return $recipes->first()->category === 'Masakan Luar Negeri';
        });
    }
}
