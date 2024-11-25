<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class EditorController extends Controller
{
    // Tampilkan daftar resep
    public function index()
    {
        $recipes = Recipe::with('user')->paginate(10); // Dengan relasi user
        return view('dashboard.editor.recipes', compact('recipes'));
    }

    // Approve resep
    public function approve($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->status = 'approved'; // Status bisa diubah sesuai kebutuhan
        $recipe->save();

        return redirect()->back()->with('success', 'Resep berhasil di-approve.');
    }

    // Decline resep
    public function decline($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->status = 'declined'; // Status bisa diubah sesuai kebutuhan
        $recipe->save();

        return redirect()->back()->with('success', 'Resep berhasil ditolak.');
    }

    // Hapus resep
    public function delete($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return redirect()->back()->with('success', 'Resep berhasil dihapus.');
    }
}
