<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\StatusRecipe;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class RecipesController extends Controller
{
    //menampilkan resep ke menu resepku
    public function index()
    {
        $recipes = Recipe::with('user')->where('user_id', auth()->id())->latest()->paginate(6);
        // Cek apakah ada resep dengan status Declined dan alasan
        $declineMessages = [];
        foreach ($recipes as $recipe) {
            if ($recipe->status_recipes_id == 3 && $recipe->decline_reason) {
                $declineMessages[] = 'Resep "' . $recipe->title . '" ditolak dengan alasan: ' . $recipe->decline_reason;
            }
        }

        // Simpan semua pesan decline ke dalam session
        if (!empty($declineMessages)) {
            session()->flash('decline_message', implode('<br>', $declineMessages));
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
        DB::transaction(function () use ($request) {
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
        });

        // Kembalikan respons setelah transaksi berhasil
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
        DB::transaction(function () use ($request, $id) {
            $recipe = Recipe::where('recipe_id', $id)->firstOrFail();
            if ($recipe->user_id !== auth()->id()) {
                abort(403, 'Unauthorized action.');
            }

            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'ingredients' => 'required|array',
                'ingredients.*' => 'required|string|max:255',
                'steps' => 'required|array',
                'steps.*' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'category' => 'required|string',
            ], [
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Format gambar yang diizinkan hanya jpeg, png, dan jpg.',
                'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
            ]);

            if ($request->hasFile('image')) {
                $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('assets/upload'), $imageName);
                $validatedData['image'] = 'assets/upload/' . $imageName;

                // Hapus gambar lama jika ada
                if ($recipe->image && file_exists(public_path($recipe->image))) {
                    unlink(public_path($recipe->image));
                }
            }

            $recipe->update([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'],
                'ingredients' => json_encode($validatedData['ingredients']),
                'steps' => json_encode($validatedData['steps']),
                'image' => $validatedData['image'] ?? $recipe->image,
                'category' => $validatedData['category'],
            ]);
        });

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
        DB::transaction(function () use ($request) {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'ingredients' => 'required|array',
                'ingredients.*' => 'required|string|max:255',
                'steps' => 'required|array',
                'steps.*' => 'required|string|max:255',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'category' => 'required|string',
                'status' => 'required',
            ], [
                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Format gambar yang diizinkan hanya jpeg, png, dan jpg.',
                'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
            ]);

            Log::info('Validated data (Editor):', $validatedData);

            if ($request->hasFile('image')) {
                $imageName = time() . '-' . $request->file('image')->getClientOriginalName();
                $request->file('image')->move(public_path('assets/upload'), $imageName);
                $validatedData['image'] = 'assets/upload/' . $imageName;
            }

            Recipe::create([
                'title' => $validatedData['title'],
                'description' => $validatedData['description'] ?? null,
                'ingredients' => json_encode($validatedData['ingredients']),
                'steps' => json_encode($validatedData['steps']),
                'image' => $validatedData['image'] ?? null,
                'category' => $validatedData['category'],
                'user_id' => auth()->id(),
                'status_recipes_id' => $request->status,
            ]);
        });

        return redirect()->route('dashboard.editor.recipes.index')->with('success', 'Resep berhasil ditambahkan.');
    }
}
