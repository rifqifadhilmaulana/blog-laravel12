<?php

namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use AuthorizesRequests;
    /**
     * Tampilkan semua post (global, bisa filter, search, dll)
     */
    public function index()
    {
        return view('posts', [
            'title' => 'Artikel',
            'posts' => Post::with(['author', 'category'])
                           ->filter(request(['search', 'category', 'author']))
                           ->latest()
                           ->paginate(9)
                           ->withQueryString()
        ]);
    }

    /**
     * Tampilkan detail post berdasarkan slug
     */
  public function show(Post $post)
{
     $post->load([
    'author',
    'favorites',
    'comments' => function ($query) {
        $query->whereNull('parent_id')
              ->where('is_hidden', false)
              ->with([
                  'user', // user komentar
                  'parent.user', // parent + parent user
                  'replies' => function ($q) { // 1 level balasan
                      $q->where('is_hidden', false)
                        ->with(['user', 'parent.user']); // user + parent
                  },
              ])
              ->latest('created_at');
    }
]);


    return view('post', [
        'title' => "Single Post",
        'post'  => $post
    ]);
}


    /**
     * Tampilkan semua artikel dari 1 author
     */
    public function author(User $user)
    {
        return view('posts', [
            'title' => "Artikel by " . $user->username,
            'posts' => $user->posts()->with(['author', 'category'])->latest()->paginate(9)
        ]);
    }

    /**
     * Tampilkan semua artikel dalam 1 kategori
     */
    public function category(Category $category)
    {
        return view('posts', [
            'title' => "Articles in " . $category->name,
            'posts' => $category->posts()->with(['author', 'category'])->latest()->paginate(9)
        ]);
    }

    /**
     * Artikel milik user login
     */
    public function myPosts(Request $request)
{
    $query = Post::with('category')
        ->where('author_id', Auth::id())
        ->latest();

    if ($request->search) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $posts = $query->paginate(9)->withQueryString();

    return view('mypost', [
        'title' => 'Postinganku',
        'posts' => $posts
    ]);
}

    /**
     * Form create post
     */
    public function create()
    {
        $this->authorize('create', Post::class);

        return view('create', [
            'title' => 'Buat Post Baru',
            'categories' => Category::all()
        ]);
    }

    /**
     * Simpan post baru
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|max:50',
            'body' => 'required|min:180',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // generate slug otomatis
        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();

        if ($request->file('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }
        $validated['author_id'] = Auth::id();

        Post::create($validated);

        return redirect()->route('myposts')->with('success', 'Post berhasil dibuat!');
    }

    /**
     * Form edit post
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);

        return view('edit', [
            'title' => 'Edit Post',
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update post
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

                $validated = $request->validate([
                'title' => 'required|string|max:50',
                'body' => 'required|min:180',
                'category_id' => 'required|exists:categories,id',
                'image' => 'nullable|image|max:2048',
            ]);

            // kalau user hapus gambar
            if ($request->remove_image == 1 && $post->image) {
                Storage::disk('public')->delete($post->image);
                $post->image = null;
            }

            // kalau upload gambar baru
            if ($request->hasFile('image')) {
                // hapus gambar lama dulu
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $validated['image'] = $request->file('image')->store('posts', 'public');
                $post->image = $validated['image'];
            }

            $post->title = $validated['title'];
            $post->body = $validated['body'];
            $post->category_id = $validated['category_id'];
            $post->save();

             if($post->wasChanged()){
                return redirect()->route('myposts')->with('success', 'Artikel berhasil diperbarui!');
            }else{
                return redirect()->route('myposts')->with('info', 'Tidak ada perubahan data pada artikel.');
            }
        }
    /**
     * Hapus post
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('myposts')->with('success', 'Post berhasil dihapus!');
    }
}
