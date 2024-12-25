<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Mail\EditorAccountMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // menampilkan editor
    public function editors()
    {
        // Ambil semua user dengan role editor (role_id = 2)
        $editors = User::where('role_id', 2)
            ->with('status')
            ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan waktu pembuatan terbaru
            ->paginate(10);

        return view('dashboard.admin.editor', compact('editors'));
    }

    //menyimpan editor
    public function storeEditor(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ]);

        // Tambahkan editor baru
        $editor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role_id' => 2, // Role editor
            'password' => Hash::make($request->password),
        ]);

        // Kirim email dengan detail akun editor
        Mail::to($editor->email)->send(new EditorAccountMail($editor, $request->password));


        // Redirect kembali ke halaman editor dengan notifikasi
        return redirect()->route('admin.editors')->with('success', 'Editor berhasil ditambahkan dan detail akun dikirim ke email.');
    }

    //menghapus editor
    public function deleteEditor($id)
    {
        // Hapus editor berdasarkan ID
        User::where('user_id', $id)->firstOrFail()->delete();

        return redirect()->route('admin.editors')->with('success', 'Editor berhasil dihapus.');
    }

    //untuk nonaktif / aktif
    public function toggleStatus($id)
    {
        // Ambil user berdasarkan ID
        $user = User::where('user_id', $id)->firstOrFail();

        // Ganti status_id (1: Aktif, 2: Nonaktif)
        $user->status_id = ($user->status_id == 1) ? 2 : 1;
        $user->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    // Kelola Member
    public function members()
    {
        // Ambil semua user dengan role member (role_id = 3)
        $members = User::where('role_id', 3)
            ->with('status')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('dashboard.admin.member', compact('members'));
    }

    //delete member
    public function deleteMember($id)
    {
        // Hapus member berdasarkan ID
        User::where('user_id', $id)->firstOrFail()->delete();
        return redirect()->route('admin.members')->with('success', 'Member berhasil dihapus.');
    }
}
