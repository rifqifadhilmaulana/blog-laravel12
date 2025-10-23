<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function index()
    {
        $categories = Category::when(request('search'), function($query, $search) {
                        $query->where('name', 'like', "%{$search}%");
                    })->paginate(10)->withQueryString();

        return view('admin.categories.index', [
            'title' => 'Kelola Kategori',
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.categories.create', [
            'title' => 'Buat Kategori Baru',
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'color' => 'required|string|max:20', 
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        Category::create($validated);


        return redirect()->route('admin.categories.index')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'title' => 'Edit Kategori',
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,'.$category->id,
            'color' => 'required|string|max:20', 
        ]);
        
        $validated['slug'] = Str::slug($validated['name']);
         $category->name = $validated['name'];
         $category->slug = $validated['slug'];
         $category->color = $validated['color'];
         $category->save();
         
         if($category->wasChanged()) {
               return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil diperbarui!');
         }

       return redirect()->route('admin.categories.index')->with('info', 'Tidak ada perubahan yang dilakukan pada kategori.');
    }

    public function destroy(Category $category)
    {
        // Cek apakah masih ada post
        if ($category->posts()->count() > 0) {
             return back()->with('error', 'Tidak bisa menghapus kategori yang masih memiliki postingan.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus!');
    }
}