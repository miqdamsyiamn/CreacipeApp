<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use Illuminate\Support\Facades\DB;

class EditorController extends Controller
{
    // Tampilkan daftar resep
    public function index()
    {
        // Ambil semua resep dengan relasi user dan status
        $recipes = Recipe::with(['user', 'status'])->orderBy('created_at', 'desc')->paginate(10);

        // Arahkan ke view recipes.blade.php dengan data resep
        return view('dashboard.editor.recipes', compact('recipes'));
    }

    // Approve resep
    public function approve($id)
    {
        DB::transaction(function () use ($id) {
            $recipe = Recipe::where('recipe_id', $id)->firstOrFail();

            // Update status dan tanggal approved
            $recipe->update([
                'status_recipes_id' => 2, // Approved
                'accepted_date' => now(),
            ]);
        });

        return redirect()->back()->with('success', 'Resep berhasil disetujui.');
    }

    // Decline resep
    public function decline(Request $request, $id)
    {
        DB::transaction(function () use ($request, $id) {
            $recipe = Recipe::where('recipe_id', $id)->firstOrFail();

            // Update status, alasan, dan tanggal declined
            $recipe->update([
                'status_recipes_id' => 3, // Declined
                'declined_date' => now(),
                'decline_reason' => $request->decline_reason,
            ]);
        });

        return redirect()->back()->with('success', 'Resep berhasil ditolak.');
    }

    // Hapus resep
    public function delete($id)
    {
        DB::transaction(function () use ($id) {
            $recipe = Recipe::where('recipe_id', $id)->firstOrFail();

            // Hapus data resep
            $recipe->delete();
        });

        return redirect()->back()->with('success', 'Resep berhasil dihapus.');
    }

    // untuk klik ke menu dashboard.
    public function dashboard()
    {
        $recipes = []; // Kirim array kosong atau data dari database jika diperlukan
        return view('dashboard.editor.editor', compact('recipes'));
    }
}
