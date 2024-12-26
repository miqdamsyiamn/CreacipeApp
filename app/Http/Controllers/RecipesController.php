<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\StatusRecipe;
use Illuminate\Support\Facades\Log;

class RecipesController extends Controller
{
    //menampilkan resep ke menu resepku
    public function index()
    {
        $recipes = Recipe::with('user')->where('user_id', auth()->id())->latest()->paginate(6);
        // Cek apakah ada resep dengan status Declined dan alasan
        foreach ($recipes as $recipe) {
            if ($recipe->status_recipes_id == 3 && $recipe->decline_reason) {
                // Simpan pesan decline ke dalam flash session
                session()->flash('decline_message', 'Resep "' . $recipe->title . '" ditolak dengan alasan: ' . $recipe->decline_reason);
            }
        }
        return view('member.recipes.index', compact('recipes'));
    }

    // Menampilkan form tambah resep
    public function create()
    {
        return view('member.recipes.create');
    }

    // Menyimpan data resep oleh member
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array', // Dynamic Field untuk bahan
            'ingredients.*' => 'required|string|max:255',
            'steps' => 'required|array', // Dynamic Field untuk langkah
            'steps.*' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string',
        ], [
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan hanya jpeg, png, dan jpg.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        Log::info('Validated data:', $validatedData);

        // Cek apakah file image tersedia
        if ($request->hasFile('image')) {
            $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/upload'), $imageName);
            $validatedData['image'] = 'assets/upload/' . $imageName;
        }

        Log::info('Data before save:', $validatedData);

        // Simpan resep
        Recipe::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'ingredients' => json_encode($validatedData['ingredients']), // Langsung encode array
            'steps' => json_encode($validatedData['steps']), // Langsung encode array
            'image' => $validatedData['image'] ?? null,
            'user_id' => auth()->id(),
            'status_recipes_id' => 1,
            'category' => $validatedData['category'],
        ]);

        return redirect()->route('member.recipes.index')->with('success', 'Resep berhasil ditambahkan dan menunggu persetujuan.');
    }

    public function edit($id)
    {
        $recipe = Recipe::where('recipe_id', $id)->firstOrFail();
        // Cek apakah resep milik user yang sedang login
        if ($recipe->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('member.recipes.edit', compact('recipe'));
    }

    //update oleh member
    public function update(Request $request, $id)
    {
        $recipe = Recipe::where('recipe_id', $id)->firstOrFail();
        // Cek apakah resep milik user yang sedang login
        if ($recipe->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array', // Dynamic Field untuk bahan
            'ingredients.*' => 'required|string|max:255',
            'steps' => 'required|array', // Dynamic Field untuk langkah
            'steps.*' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string',
        ], [
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan hanya jpeg, png, dan jpg.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        // Update gambar jika ada
        if ($request->hasFile('image')) {
            $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/upload'), $imageName);
            $validatedData['image'] = 'assets/upload/' . $imageName;

            // Hapus gambar lama jika ada
            if ($recipe->image && file_exists(public_path($recipe->image))) {
                unlink(public_path($recipe->image));
            }
        }

        // Update data resep
        $recipe->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'ingredients' => json_encode($validatedData['ingredients']), // Langsung encode array
            'steps' => json_encode($validatedData['steps']), // Langsung encode array
            'image' => $validatedData['image'] ?? $recipe->image,
            'category' => $validatedData['category'],
        ]);

        return redirect()->route('member.recipes.index')->with('success', 'Resep berhasil diperbarui.');
    }

    //mengirimkan resep yg di approve ke home
    public function home(Request $request)
    {
        // Mengambil parameter kategori dari URL
        $category = $request->query('category');
        // Filter resep berdasarkan kategori (jika ada)
        $query = Recipe::where('status_recipes_id', 2); // Status Approved
        if ($category) {
            // Cocokkan dengan kategori yang tersimpan di database
            if ($category === 'Indonesia') {
                $query->where('category', 'Masakan Indonesia');
            } elseif ($category === 'Luar Negeri') {
                $query->where('category', 'Masakan Luar Negeri');
            }
        }
        // Tambahkan paginasi dengan 6 resep per halaman
        $approvedRecipes = $query->latest()->paginate(6);
        return view('home.home', compact('approvedRecipes')); // Kirim ke view
    }


    //lihat resep di home
    public function show($id)
    {
        // Ambil data resep berdasarkan ID
        $recipe = Recipe::with('user')->where('recipe_id', $id)->firstOrFail();

        // Kirim data ke view
        return view('recipes.show', compact('recipe'));
    }


    // Membuat resep oleh editor
    public function createByEditor()
    {
        return view('dashboard.editor.recipes.create'); // View khusus editor
    }

    // Menyimpan resep yang dibuat oleh editor
    public function storeByEditor(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|array', // Dynamic Field untuk bahan
            'ingredients.*' => 'required|string|max:255',
            'steps' => 'required|array', // Dynamic Field untuk langkah
            'steps.*' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'category' => 'required|string', // Tambahkan kategori
            'status' => 'required' // Validasi status (Pending, Approved, Declined)
        ], [
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar yang diizinkan hanya jpeg, png, dan jpg.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        Log::info('Validated data (Editor):', $validatedData);

        // Cek apakah file image tersedia
        if ($request->hasFile('image')) {
            $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
            $request->file('image')->move(public_path('assets/upload'), $imageName);
            $validatedData['image'] = 'assets/upload/' . $imageName;
        }

        Log::info('Data before save (Editor):', $validatedData);

        // Simpan resep
        Recipe::create([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'] ?? null,
            'ingredients' => json_encode($validatedData['ingredients']), // Langsung encode array
            'steps' => json_encode($validatedData['steps']), 
            'image' => $validatedData['image'] ?? null,
            'category' => $validatedData['category'],
            'user_id' => auth()->id(),
            'status_recipes_id' => $request->status,
        ]);

        return redirect()->route('dashboard.editor.recipes.index')->with('success', 'Resep berhasil ditambahkan.');
    }

    //menampilkan resep yang dibuat editor 
    public function showEditorRecipes()
    {
        // Ambil semua resep tanpa memfilter status
        $recipes = Recipe::with('user')->latest()->get();

        // Kirim data ke view
        return view('recipes.showeditor', compact('recipes'));
    }
}
