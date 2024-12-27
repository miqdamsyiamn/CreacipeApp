<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Recipe;

class EditorRecipesControllerTest extends TestCase
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
    public function it_can_display_recipes_in_dashboard_editor()
    {
        $this->authenticateEditor();

        // Buat data resep palsu
        Recipe::factory()->count(5)->create([
            'user_id' => User::factory()->create()->user_id,
        ]);

        $response = $this->get(route('dashboard.editor.recipes.index'));

        $response->assertStatus(200);
        $response->assertViewIs('dashboard.editor.recipes.index');
        $response->assertViewHas('recipes');
    }

    /** @test */
    public function it_can_show_editor_recipe_details()
    {
        $this->authenticateEditor();

        // Buat data resep palsu
        $recipe = Recipe::factory()->create();

        $response = $this->get(route('recipes.showeditor', $recipe->recipe_id));

        $response->assertStatus(200);
        $response->assertJson([
            'title' => $recipe->title,
            'description' => $recipe->description ?? 'Tidak ada deskripsi.',
            'image' => $recipe->image ? asset($recipe->image) : asset('https://via.placeholder.com/600x400'),
            'ingredients' => json_decode($recipe->ingredients),
            'steps' => json_decode($recipe->steps),
        ]);
    }

    /** @test */
    public function it_can_update_a_recipe()
    {
        $this->authenticateEditor();

        // Gunakan disk palsu
        Storage::fake('public');

        // Buat data resep
        $recipe = Recipe::factory()->create();

        // Data untuk update
        $data = [
            'title' => 'Updated Recipe Title',
            'description' => 'Updated Recipe Description',
            'ingredients' => ['Updated Ingredient 1', 'Updated Ingredient 2'],
            'steps' => ['Updated Step 1', 'Updated Step 2'],
            'category' => 'Updated Category',
            'image' => UploadedFile::fake()->image('updated_recipe.jpg'),
        ];

        $response = $this->put(route('editor.recipes.update', $recipe->recipe_id), $data);

        // Periksa redirect
        $response->assertRedirect(route('dashboard.editor.recipes.index'));
        $response->assertSessionHas('success', 'Resep berhasil diperbarui!');

        // Verifikasi data di database
        $this->assertDatabaseHas('recipes', [
            'recipe_id' => $recipe->recipe_id,
            'title' => 'Updated Recipe Title',
        ]);

        // Verifikasi bahwa file disimpan di disk palsu
        Storage::disk('public')->assertExists('assets/upload/' . $data['image']->hashName());
    }
}
