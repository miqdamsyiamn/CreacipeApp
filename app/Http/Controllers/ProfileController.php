<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    // Menampilkan halaman profil user
    public function showProfile()
{
    $user = auth()->user(); // Ambil data pengguna yang sedang login
    return view('profile.showprofile', compact('user')); // Pastikan path view benar
}


    // Menampilkan form edit profil
    public function edit()
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        // Kirim ke view edit profil
        return view('profile.edit', compact('user'));
    }

    // Menyimpan perubahan profil user
    public function update(Request $request)
    {
        // Ambil data user yang sedang login
        $user = auth()->user();

        // Validasi input
        $validatedData = $request->validate([
            'bio' => 'nullable|string|max:500',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Cek apakah ada gambar profil yang diupload
        if ($request->hasFile('profile_picture')) {
            // Tentukan lokasi penyimpanan
            $destinationPath = public_path('assets/upload');
            // Buat nama unik untuk file
            $fileName = time() . '-' . $request->file('profile_picture')->getClientOriginalName();
            // Pindahkan file ke lokasi penyimpanan
            $request->file('profile_picture')->move($destinationPath, $fileName);
            // Simpan path file dalam database
            $validatedData['profile_picture'] = 'assets/upload/' . $fileName;
        }

        // Perbarui data user
        $user->update($validatedData);

        // Redirect dengan pesan sukses
        return redirect()->route('profile.showprofile')->with('success', 'Profil berhasil diperbarui.');
    }
}
