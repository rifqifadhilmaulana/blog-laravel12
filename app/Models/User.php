<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username', 
        'email',
        'password',
        'avatar',
        'bio',
        'is_admin',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }
    
    // PERBAIKAN: Mengubah nama fungsi menjadi isAdmin() (camelCase)
    // agar cocok dengan panggilan di PostPolicy dan Navbar.
    public function isAdmin(): bool {
        return $this->is_admin;
    } 

    public function posts(): HasMany {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function followings(): BelongsToMany {
        //User yang user ikuti
        return $this->belongsToMany(User::class, 'follows', 'follower_id', 'followed_id');
    }

    public function followers(): BelongsToMany {
        //User yang mengikuti user ini
        return $this->belongsToMany(User::class, 'follows', 'followed_id', 'follower_id');
    }
    public function favoritePosts(): BelongsToMany {
        return $this->belongsToMany(Post::class, 'post_user_favorites', 'user_id', 'post_id')->withTimestamps();
    }
    public function hasFavorited(Post $post): bool {
        return $this->favoritePosts()->where('post_id', $post->id)->exists();
    }

     public function comments(): HasMany // <--- TAMBAHKAN INI
    {
    return $this->hasMany(Comment::class);
    }

}