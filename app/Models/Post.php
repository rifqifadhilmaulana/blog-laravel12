<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'author_id', 'slug', 'body','category_id','image'];

    protected $with = ['author', 'category'];

    public function author(): BelongsTo {
        return $this->belongsTo(User::class,'author_id');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(Category::class);
    }
    
    public function favorites(): BelongsToMany {
        return $this->belongsToMany(User::class, 'post_user_favorites', 'post_id', 'user_id')->withTimestamps();
    }

      public function comments(): HasMany
{
    return $this->hasMany(Comment::class)
        ->whereNull('parent_id')
        ->with(['replies'])
        ->latest();
}

   public function scopeFilter(Builder $query, array $filters) {
    // Search
    $query->when($filters['search'] ?? false, function ($query, $search) {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', '%' . $search . '%')
              ->orWhereHas('author', fn($q2) =>
                  $q2->where('username', 'like', '%' . $search . '%')
                     ->orWhere('name', 'like', '%' . $search . '%')
              );
        });
    });

    // Filter kategori
    $query->when($filters['category'] ?? false, fn($query, $category) =>
        $query->whereHas('category', fn($q) =>
            $q->where('slug', $category)
        )
    );

    // Filter author langsung
    $query->when($filters['author'] ?? false, fn($query, $author) =>
        $query->whereHas('author', fn($q) =>
            $q->where('username', $author)
        )
    );
}
}



