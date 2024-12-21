<?php

namespace App\Http\Controllers;

use App\Models\Recipe;

class EditorRecipesController extends Controller
{
    public function indexEditor()
    {
        // Ambil semua resep dengan user yang membuatnya
        $recipes = Recipe::with('user')->latest()->paginate(10); // Pagination 10 resep per halaman

        // Kirim data ke view
        return view('dashboard.editor.recipes.index', compact('recipes'));
    }

    public function showEditorRecipe($id)
{
    // Ambil data resep berdasarkan ID
    $recipe = Recipe::with('user')->findOrFail($id);

    // Kirim data ke view modal
    return response()->json([
        'title' => $recipe->title,
        'description' => $recipe->description ?? 'Tidak ada deskripsi.',
        'image' => $recipe->image ? asset($recipe->image) : asset('https://via.placeholder.com/600x400'),
        'ingredients' => json_decode($recipe->ingredients),
        'steps' => json_decode($recipe->steps),
    ]);
}

}


