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

    public function showEditorRecipes()
{
    // Ambil semua resep tanpa memfilter status
    $recipes = Recipe::with('user')->latest()->get();

    // Kirim data ke view
    return view('recipes.showeditor', compact('recipes'));
}
}


