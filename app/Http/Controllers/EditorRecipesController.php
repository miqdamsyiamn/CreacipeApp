<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use Illuminate\Http\Request;

class EditorRecipesController extends Controller
{
    //menampilkan resep di dashbord editor
    public function indexEditor()
    {
        // Ambil semua resep dengan user yang membuatnya
        $recipes = Recipe::with('user')->latest()->paginate(6); // Pagination 10 resep per halaman

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

    // Memperbarui resep yang diedit
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array', // Dynamic Field untuk bahan
            'ingredients.*' => 'required|string|max:255',
            'steps' => 'required|array', // Dynamic Field untuk langkah
            'steps.*' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category' => 'required|string',
        ]);

        // Ambil data resep berdasarkan ID
        $recipe = Recipe::findOrFail($id);

        // Update data resep
        $recipe->title = $request->title;
        $recipe->description = $request->description;
        $recipe->ingredients = json_encode($request->ingredients);
        $recipe->steps = json_encode($request->steps);
        $recipe->category = $request->category;

        // Proses jika ada gambar baru yang diunggah
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($recipe->image && file_exists(public_path($recipe->image))) {
                unlink(public_path($recipe->image));
            }

            // Simpan gambar baru ke folder assets/upload
            $imagePath = $request->file('image')->move('assets/upload', time() . '_' . $request->file('image')->getClientOriginalName());
            $recipe->image = $imagePath; // Simpan path gambar baru di database
        }

        // Simpan data yang sudah diubah
        $recipe->save();

        // Redirect dengan pesan sukses
        return redirect()->route('dashboard.editor.recipes.index')->with('success', 'Resep berhasil diperbarui!');
    }
}
