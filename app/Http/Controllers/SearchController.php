<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\User;

class SearchController extends Controller
{
    //search di home
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');

        // Query hanya untuk resep dengan status approved (status_id = 2)
        $recipes = Recipe::with('user')
            ->where('status_recipes_id', 2)
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                    ->orWhere('ingredients', 'like', "%$keyword%")
                    ->orWhereHas('user', function ($subQuery) use ($keyword) {
                        $subQuery->where('name', 'like', "%$keyword%");
                    });
            })
            ->paginate(9);

        // Return ke home view dengan variabel approvedRecipes
        return view('home.home', [
            'approvedRecipes' => $recipes,
            'message' => "Hasil pencarian untuk: \"$keyword\""
        ]);
    }

    //search resep ku
    public function searchUserRecipes(Request $request)
    {
        $keyword = $request->input('keyword');
        // Query hanya untuk resep milik user yang sedang login
        $recipes = Recipe::where('user_id', auth()->id()) // Filter berdasarkan user login
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                    ->orWhere('ingredients', 'like', "%$keyword%");
            })
            ->paginate(9);

        // Return ke halaman resep milik user (Resepku)
        return view('member.recipes.index', [
            'recipes' => $recipes,
            'message' => "Hasil pencarian untuk: \"$keyword\""
        ]);
    }

    // Method untuk mencari Editor
    public function searchEditors(Request $request)
    {
        $keyword = $request->input('keyword');

        // Query pencarian editor berdasarkan nama atau email
        $editors = User::where('role_id', 2) // role_id 2 = Editor
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%");
            })
            ->paginate(10);

        return view('dashboard.admin.editor', [
            'editors' => $editors,
            'message' => "Hasil pencarian editor untuk: \"$keyword\""
        ]);
    }

    //search member
    public function searchMembers(Request $request)
    {
        $keyword = $request->input('keyword');

        // Query pencarian untuk member
        $members = User::where('role_id', '3') // Filter hanya role 'member'
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('email', 'like', "%$keyword%");
            })
            ->paginate(10);

        // Mengembalikan view dengan hasil pencarian
        return view('dashboard.admin.member', [
            'members' => $members,
            'message' => "Hasil pencarian untuk: \"$keyword\""
        ]);
    }

    //search yang di lakukan editor di menu kelola resep
    public function searchEditorRecipes(Request $request)
    {
        $keyword = $request->input('keyword');

        // Query untuk mencari resep
        $recipes = Recipe::with('user', 'status')
            ->where('title', 'like', "%$keyword%")
            ->orWhereHas('user', function ($query) use ($keyword) {
                $query->where('name', 'like', "%$keyword%");
            })
            ->paginate(10);

        // Kembalikan hasil pencarian ke halaman kelola resep
        return view('dashboard.editor.recipes', [
            'recipes' => $recipes,
            'message' => "Hasil pencarian untuk: \"$keyword\""
        ]);
    }

    //search resep pada semua resep oleh editor
    public function searchAllRecipes(Request $request)
    {
        $keyword = $request->input('keyword');

        // Periksa apakah pengguna berada di halaman 'Kelola Resep'
        $isManageRecipes = $request->is('dashboard/editor/recipes/manage*');

        // Query untuk resep berdasarkan kondisi halaman
        $recipes = Recipe::with('user', 'status')
            ->where(function ($query) use ($keyword) {
                $query->where('title', 'like', "%$keyword%")
                    ->orWhere('description', 'like', "%$keyword%")
                    ->orWhere('ingredients', 'like', "%$keyword%")
                    ->orWhereHas('user', function ($subQuery) use ($keyword) {
                        $subQuery->where('name', 'like', "%$keyword%");
                    });
            });

        // Jika di halaman 'Kelola Resep', tambahkan filter status
        if ($isManageRecipes) {
            $recipes->where('status_recipes_id', 1);
        }

        $recipes = $recipes->paginate(10);

        // Kirim data ke view yang sesuai
        $view = $isManageRecipes ? 'dashboard.editor.manage' : 'dashboard.editor.recipes.index';

        return view($view, [
            'recipes' => $recipes,
            'message' => "Hasil pencarian untuk: \"$keyword\""
        ]);
    }
}
