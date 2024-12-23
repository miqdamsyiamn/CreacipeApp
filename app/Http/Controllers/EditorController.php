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
        $recipes = Recipe::with(['user', 'status'])->orderBy('created_at', 'desc')->paginate(10);

        // Arahkan ke view recipes.blade.php dengan data resep
        return view('dashboard.editor.recipes', compact('recipes'));
    }

    // Approve resep
    public function approve($id)
    {
        $recipe = Recipe::findOrFail($id);
        // Update status dan tanggal approved
        $recipe->update([
            'status_id' => 2,
            'accepted_date' => now(),
        ]);

        return redirect()->back()->with('success', 'Resep berhasil disetujui.');
    }

    // Decline resep
    public function decline(Request $request, $id)
    {
        // Set status menjadi declined (ID status: 3)
        $recipe = Recipe::findOrFail($id);
        // Update status, alasan, dan tanggal declined
        $recipe->update([
            'status_id' => 3, // Declined
            'declined_date' => now(),
            'decline_reason' => $request->decline_reason,
        ]);
        
        return redirect()->back()->with('success', 'Resep berhasil ditolak.');
    }

    // Hapus resep
    public function delete($id)
    {
        $recipe = Recipe::findOrFail($id);
        $recipe->delete();

        return redirect()->back()->with('success', 'Resep berhasil dihapus.');
    }

    // untuk klik ke menu dashboard.
    public function dashboard()
    {
        $recipes = []; // Kirim array kosong atau data dari database jika diperlukan
        return view('dashboard.editor.editor', compact('recipes'));
    }
}
