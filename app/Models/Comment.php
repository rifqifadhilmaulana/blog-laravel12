<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'body',
        'parent_id',
        'is_hidden',
    ];
    protected $with = ['post', 'user','replies'];

    /**
     * Komentar milik satu Post.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    

    /**
     * Komentar ditulis oleh satu User.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
public function replies()
{
    return $this->hasMany(Comment::class, 'parent_id')
                ->where('is_hidden', false)
                ->with('user'); // balasan juga ambil user
}



}