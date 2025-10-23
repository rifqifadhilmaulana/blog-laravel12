<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;



class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'body' => 'required|string',
            'post_id' => 'required|exists:posts,id',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $comment = Comment::create([
            'post_id' => $request->post_id,
            'user_id' => auth()->id(),
            'body' => $request->body,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()
            ->to(url()->previous() . '#comment-' . $comment->id)
            ->with('success', $request->parent_id ? 'Balasan berhasil dikirim.' : 'Komentar berhasil dikirim.');
    }

    public function hide($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id === auth()->id()) {
            $comment->update(['is_hidden' => true]);
            return back()->with('success', 'Komentar disembunyikan.');
        }

        return back()->with('error', 'Kamu tidak bisa menyembunyikan komentar ini.');
    }

    public function unhide($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id === auth()->id()) {
            $comment->update(['is_hidden' => false]);
            return back()->with('success', 'Komentar ditampilkan kembali.');
        }

        return back()->with('error', 'Kamu tidak bisa menampilkan komentar ini.');
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id === auth()->id()) {
            // Hapus balasan jika ada
            if ($comment->replies()->exists()) {
                $comment->replies()->delete();
            }

            $comment->delete();
            return back()->with('success', 'Komentar berhasil dihapus.');
        }

        return back()->with('error', 'Kamu tidak bisa menghapus komentar ini.');
    }
}
