<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use App\Models\Recipe;

class SearchControllerTest extends TestCase
{
  use WithFaker;

  /**
   * Test searching for approved recipes in home.
   */
  public function test_search_approved_recipes_in_home()
  {
    // Create approved recipes
    $recipes = Recipe::factory()->count(3)->create(['status_recipes_id' => 2]);

    // Perform search
    $response = $this->get(route('home.search', ['keyword' => $recipes[0]->title]));

    $response->assertStatus(200)
      ->assertViewHas('approvedRecipes')
      ->assertSee($recipes[0]->title);
  }

  /**
   * Test searching user recipes in "Resepku".
   */
  /** @test */
  public function it_can_search_user_recipes()
  {
    // Buat user login
    $user = User::factory()->create();

    // Buat beberapa resep milik user tersebut
    Recipe::factory()->create([
      'title' => 'Resep User 1',
      'user_id' => $user->user_id,
    ]);

    Recipe::factory()->create([
      'title' => 'Resep User 2',
      'user_id' => $user->user_id,
    ]);

    // Buat resep lain milik user lain
    Recipe::factory()->create([
      'title' => 'Resep Lain',
    ]);

    // Login sebagai user
    $this->actingAs($user);

    // Kirim permintaan pencarian
    $response = $this->get(route('member.recipes.search', ['keyword' => 'Resep User']));

    // Verifikasi
    $response->assertStatus(200);
    $response->assertViewIs('member.recipes.index');
    $response->assertViewHas('recipes');
    $response->assertSee('Resep User 1');
    $response->assertSee('Resep User 2');
    $response->assertDontSee('Resep Lain');
  }

  /**
   * Test searching for editors in admin panel.
   */
  public function test_search_editors()
  {
    $admin = User::factory()->create(['role_id' => 1]);
    $this->actingAs($admin);

    // Create editors
    $editors = User::factory()->count(3)->create(['role_id' => 2]);

    // Perform search
    $response = $this->get(route('admin.editors.search', ['keyword' => $editors[0]->name]));

    $response->assertStatus(200)
      ->assertViewHas('editors')
      ->assertSee($editors[0]->name);
  }

  /**
   * Test searching for members in admin panel.
   */
  public function test_search_members()
  {
    $admin = User::factory()->create(['role_id' => 1]);
    $this->actingAs($admin);

    // Create members
    $members = User::factory()->count(3)->create(['role_id' => 3]);

    // Perform search
    $response = $this->get(route('admin.members.search', ['keyword' => $members[0]->name]));

    $response->assertStatus(200)
      ->assertViewHas('members')
      ->assertSee($members[0]->name);
  }

  /**
   * Test searching recipes in the editor's recipe management page.
   */
  public function test_search_editor_recipes()
  {
    $editor = User::factory()->create(['role_id' => 2]);
    $this->actingAs($editor);

    // Create recipes
    $recipes = Recipe::factory()->count(3)->create();

    // Perform search
    $response = $this->get(route('editor.recipes.search', ['keyword' => $recipes[0]->title]));

    $response->assertStatus(200)
      ->assertViewHas('recipes')
      ->assertSee($recipes[0]->title);
  }

  /**
   * Test searching recipes in the editor's "All Recipes" page.
   */
  public function test_search_all_recipes()
  {
    $editor = User::factory()->create(['role_id' => 2]);
    $this->actingAs($editor);

    // Create recipes
    $recipes = Recipe::factory()->count(3)->create();

    // Perform search
    $response = $this->get(route('editor.searchAllRecipes', ['keyword' => $recipes[0]->title]));

    $response->assertStatus(200)
      ->assertViewHas('recipes')
      ->assertSee($recipes[0]->title);
  }
}
