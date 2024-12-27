<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Models\User;
use App\Models\Recipe;

class EditorControllerTest extends TestCase
{
  use DatabaseTransactions;

  protected function authenticateEditor()
  {
    $editor = User::factory()->create([
      'role_id' => 2,
      'status_id' => 1,
    ]);

    $this->actingAs($editor);
  }

  /** @test */
  public function it_can_display_recipes_list()
  {
    $this->authenticateEditor();

    Recipe::factory()->count(5)->create();

    $response = $this->get(route('editor.recipes.index'));

    $response->assertStatus(200);
    $response->assertViewIs('dashboard.editor.recipes');
    $response->assertViewHas('recipes');
  }

  /** @test */
  public function it_can_approve_a_recipe()
  {
    $this->authenticateEditor();

    $recipe = Recipe::factory()->create([
      'status_recipes_id' => 1,
    ]);

    $response = $this->patch(route('editor.recipes.approve', $recipe->recipe_id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Resep berhasil disetujui.');

    $this->assertEquals(2, $recipe->fresh()->status_recipes_id);
  }


  /** @test */
  public function it_can_decline_a_recipe()
  {
    $this->authenticateEditor();

    $recipe = Recipe::factory()->create([
      'status_recipes_id' => 1,
    ]);

    $response = $this->patch(route('editor.recipes.decline', $recipe->recipe_id), [
      'decline_reason' => 'Tidak sesuai standar.',
    ]);

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Resep berhasil ditolak.');

    $this->assertEquals(3, $recipe->fresh()->status_recipes_id);
    $this->assertEquals('Tidak sesuai standar.', $recipe->fresh()->decline_reason);
  }


  /** @test */
  public function it_can_delete_a_recipe()
  {
    $this->authenticateEditor();

    $recipe = Recipe::factory()->create();

    $response = $this->delete(route('editor.recipes.delete', $recipe->recipe_id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Resep berhasil dihapus.');

    $this->assertDatabaseMissing('recipes', [
      'recipe_id' => $recipe->recipe_id,
    ]);
  }

  /** @test */
  public function it_can_display_dashboard()
  {
    $this->authenticateEditor();

    $response = $this->get(route('editor.dashboard'));

    $response->assertStatus(200);
    $response->assertViewIs('dashboard.editor.editor');
  }
}
