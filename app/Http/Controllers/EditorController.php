<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;

class EditorController extends Controller
{
    // Tampilkan daftar resep
    public function index()
    {
        // Ambil semua resep dengan relasi user dan status
        $recipes = Recipe::with(['user', 'status'])->paginate(10);

        // Arahkan ke view recipes.blade.php dengan data resep
        return view('dashboard.editor.recipes', compact('recipes'));
    }

    // Approve resep
    public function approve($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->status_id = 2; // 2 = Approved
        $recipe->save();

        return redirect()->back()->with('success', 'Resep berhasil disetujui.');
    }

    // Decline resep
    public function decline($id)
    {
        // Set status menjadi declined (ID status: 3)
        $recipe = Recipe::findOrFail($id);
        $recipe->status_id = 3; // 3 = Declined
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
