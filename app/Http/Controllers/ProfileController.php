<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Profil saya (user yang sedang login).
     */
    public function myProfile()
    {
        $user = Auth::user();

        $posts = Post::where('author_id', $user->id)
            ->latest()
            ->paginate(6);

        return view('profile.show', [
            'user'  => $user,
            'title' => 'Profil Saya',
            'posts' => $posts,
        ]);
    }

    /**
     * Profil user lain berdasarkan username.
     */
    public function show(User $user)
    {
        $posts = Post::where('author_id', $user->id)
            ->latest()
            ->paginate(6);

        return view('profile.show', [
            'user'  => $user,
            'title' => 'Profil ' . $user->username,
            'posts' => $posts,
        ]);
    }

    /**
     * Form edit profil (hanya untuk user login).
     */
    public function edit()
    {
        $user = Auth::user();

        return view('profile.edit', [
            'user'  => $user,
            'title' => 'Edit Profil',
        ]);
    }

    /**
     * Update data profil (hanya untuk user login).
     */
    public function update(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        $data = $request->validate([
            'name'     => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255|unique:users,username,' . $user->id,
            'bio'      => 'nullable|string',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.show', $user->id)
            ->with('success', 'Profil berhasil diperbarui!');
    }
}
