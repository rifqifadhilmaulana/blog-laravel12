<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class FavoriteController extends Controller
{
    // toggle favorite (simpan / batalkan)
    public function toggle(Post $post, Request $request)
    {
        $user = $request->user();

        if ($user->hasFavorited($post)) {
            // Batalkan simpan
            $user->favoritePosts()->detach($post->id);
            $message = 'Postingan dihapus dari favorit.';
        } else {
            // Simpan
            $user->favoritePosts()->attach($post->id);
            $message = 'Postingan ditambahkan ke favorit.';
        }

        return back()->with('success', $message);
    }

    // halaman daftar favorit user
    public function favorite(Request $request)
    {
        $posts = $request->user()
                        ->favoritePosts()
                        ->with('author','category')
                        ->latest('post_user_favorites.created_at')
                        ->paginate(10);

        return view('favorite', [
            'title' => 'Artikel Favorit Saya',
            'posts' => $posts
            
        ]);
    }
}
