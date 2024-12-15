<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\StatusRecipe;
use Illuminate\Support\Facades\Log;

class RecipesController extends Controller
{
    // Menampilkan form tambah resep
    public function create()
    {
        return view('member.recipes.create');
    }

    // Menyimpan data resep
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required',
            'steps' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'ingredients' => json_encode(explode("\n", $validatedData['ingredients'])),
            'steps' => json_encode(explode("\n", $validatedData['steps'])),
            'image' => $validatedData['image'] ?? null,
            'user_id' => auth()->id(),
            'status_id' => 1, // Status 'Pending'
        ]);
    
        return redirect()->route('member.recipes.index')->with('success', 'Resep berhasil ditambahkan dan menunggu persetujuan.');
    }

    //menampilkan resep ke menu resepku
    public function index() 
    {
        $recipes = Recipe::with('user')->where('user_id', auth()->id())->paginate(6);
        return view('member.recipes.index', compact('recipes'));
    }

    public function edit($id) 
    {
        $recipe = Recipe::findOrFail($id);
        // Cek apakah resep milik user yang sedang login
        if ($recipe->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
        return view('member.recipes.edit', compact('recipe'));
    }

    public function update(Request $request, $id)
    {
        $recipe = Recipe::findOrFail($id);

        // Cek apakah resep milik user yang sedang login
        if ($recipe->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'ingredients' => 'required|string',
            'steps' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
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
            'ingredients' => json_encode(explode("\n", $validatedData['ingredients'])),
            'steps' => json_encode(explode("\n", $validatedData['steps'])),
            'image' => $validatedData['image'] ?? $recipe->image,
        ]);

        return redirect()->route('member.recipes.index')->with('success', 'Resep berhasil diperbarui.');
    }

    // public function showApprovedRecipes()
    // {
    //     // Mengambil semua resep dengan status_id = 2
    //     $approvedRecipes = Recipe::where('status_id', 2)->latest()->get();
    
    //     // Kirimkan data ke view
    //     return view('home.home', compact('approvedRecipes'));
    // }
    
    public function home()
{
    $approvedRecipes = Recipe::where('status_id', 2)->latest()->get(); // Ambil resep dengan status_id = 2
    return view('home.home', compact('approvedRecipes')); // Kirim ke view
}

public function show($id)
{
    // Ambil data resep berdasarkan ID
    $recipe = Recipe::findOrFail($id);

    // Kirim data resep ke view
    return view('recipes.show', compact('recipe'));
}







}
