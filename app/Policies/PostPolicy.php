<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
     public function before(User $user, string $ability): ?bool
    {
        // Mengizinkan Admin melewati semua pemeriksaan kebijakan
        if ($user->isAdmin()) { // Menggunakan helper function
            return true;
        }

        return null; // Lanjutkan ke pemeriksaan method yang spesifik
    }
    
    public function create(User $user): bool
    {
        return true; // semua user login bisa create
    }

    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->author_id;
    }

    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->author_id;
    }

    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Post $post): bool
    {
        return true;
    }

    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
