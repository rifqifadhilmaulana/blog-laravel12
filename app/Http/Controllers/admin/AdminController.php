<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index()
    {
        $stats = [
            'users_count' => User::count(),
            'posts_count' => Post::count(),
            'categories_count' => Category::count(),
        ];

        return view('admin.dashboard', [
            'title' => 'Admin Dashboard',
            'stats' => $stats,
        ]);
    }

    /**
     * Tampilkan dan kelola semua Postingan.
     */
    public function postsIndex(Request $request)
    {
        $posts = Post::with(['author', 'category'])
            ->filter(request(['search', 'category', 'author'])) 
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.posts.index', [
            'title' => 'Kelola Semua Postingan',
            'posts' => $posts,
        ]);
    }

    /**
     * Hapus Postingan milik user manapun.
     */
    public function postsDestroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return back()->with('success', 'Postingan pengguna berhasil dihapus!');
    }
}