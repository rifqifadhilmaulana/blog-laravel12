<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Pastikan ini sudah diimpor

class UserController extends Controller
{
    /**
     * Tampilkan daftar semua user dengan fitur pencarian.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Logika Pencarian
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $users = $query->latest()->paginate(10)->withQueryString();

        return view('admin.users.index', [
            'title' => 'Kelola Pengguna',
            'users' => $users,
        ]);
    }

    /**
     * Hapus user tertentu, termasuk file yang terkait di storage.
     */
    public function destroy(User $user)
    {
        // Cegah Admin menghapus dirinya sendiri
        if (Auth::id() === $user->id) {
            return back()->with('error', 'Tidak dapat menghapus akun Admin yang sedang login.');
        }

        // --- HAPUS FILE TERSIMPAN DI STORAGE & HAPUS POST RECORD ---

        // 1. Iterasi melalui post untuk menghapus file dan post record dari database
        // Kita menggunakan get() untuk mengambil koleksi post sehingga kita bisa menghapusnya satu per satu.
        $user->posts()->get()->each(function ($post) {
            // Hapus file gambar postingan dari storage
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            
            // Hapus record Post. 
            // Penghapusan ini memuaskan Foreign Key Constraint di posts_author_id.
            // Penghapusan Post juga akan menghapus data di tabel post_user_favorites (jika migrasi memiliki ON DELETE CASCADE).
            $post->delete(); 
        });

        // 2. Hapus Avatar User (jika ada)
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        // 3. Hapus record user dari database.
        // Sekarang, penghapusan user akan berhasil.
        $user->delete();

        return back()->with('success', "Pengguna {$user->username} berhasil dihapus permanen.");
    }
}