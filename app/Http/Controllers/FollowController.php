<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    /**
     * Toggle Follow / Unfollow
     */
    public function toggle(User $user)
    {
        /** @var User $user */
        $authUser = auth()->user();

        // Cegah follow diri sendiri
        if ($authUser->id === $user->id) {
            return back()->with('error', 'Tidak bisa mengikuti diri sendiri!');
        }

        if ($authUser->followings()->where('followed_id', $user->id)->exists()) {
            // Sudah mengikuti → unfollow
            $authUser->followings()->detach($user->id);
            $message = "Berhenti mengikuti {$user->name}";
        } else {
            // Belum mengikuti → follow
            $authUser->followings()->attach($user->id);
            $message = "Sekarang mengikuti {$user->name}";
        }

        return back()->with('success', $message);
    }

    /**
     * Daftar following (yang diikuti user ini)
     */
    public function following(Request $request, User $user)
    {
        $query = $user->followings();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $followings = $query->get();

        return view('profile.followings', compact('user', 'followings', 'search'));
    }

    /**
     * Daftar followers (yang mengikuti user ini)
     */
    public function followers(Request $request, User $user)
    {
        $query = $user->followers();

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('username', 'like', "%{$search}%");
            });
        }

        $followers = $query->get();

        return view('profile.followers', compact('user', 'followers', 'search'));
    }
}
