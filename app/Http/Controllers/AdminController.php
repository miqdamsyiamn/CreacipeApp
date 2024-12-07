<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    // Kelola Editor
    public function editors()
    {
        // Ambil semua user dengan role editor (role_id = 2)
        $editors = User::where('role_id', 2)->with('status')->paginate(10);
        return view('dashboard.admin.editor', compact('editors'));
    }

    public function storeEditor(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Tambahkan editor baru
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => 2, // Role editor
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('admin.editors')->with('success', 'Editor berhasil ditambahkan.');
    }

    public function deleteEditor($id)
    {
        // Hapus editor berdasarkan ID
        User::findOrFail($id)->delete();

        return redirect()->route('admin.editors')->with('success', 'Editor berhasil dihapus.');
    }

    public function toggleStatus($id)
    {
        // Ambil user berdasarkan ID
        $user = User::findOrFail($id);

        // Ganti status_id (1: Aktif, 2: Nonaktif)
        $user->status_id = ($user->status_id == 1) ? 2 : 1;
        $user->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    // Kelola Member
    public function members()
    {
        // Ambil semua user dengan role member (role_id = 3)
        $members = User::where('role_id', 3)->with('status')->paginate(10);
        return view('dashboard.admin.member', compact('members'));
    }

    public function deleteMember($id)
    {
        // Hapus editor berdasarkan ID
        User::findOrFail($id)->delete();
        return redirect()->route('admin.members')->with('success', 'Member berhasil dihapus.');
    }
}
